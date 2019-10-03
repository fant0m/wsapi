<?php


namespace controller;


use core\Form;
use core\HttpResponse;
use core\InputField;
use Exception;
use model\Record;
use util\WebsupportApi;

/**
 * Class ZonesController
 * @package controller
 */
class ZonesController extends AbstractController
{
    private $api;

    public function __construct(WebsupportApi $api)
    {
        $this->api = $api;
    }

    /**
     * Zones page
     * @return string
     * @throws Exception
     */
    public function index(): string
    {
        $zones = [];
        $response = $this->api->getZones();
        if ($response->getStatusCode() == HttpResponse::STATUS_ERROR) {
            $this->addFlash('danger', 'Unexpected error has occurred!');
            // @todo log error
        } else {
            $zones = $response->getBody()['items'];
        }

        return $this->view('zones/index', compact('zones'));
    }

    /**
     * Zone detail page
     * @return string
     * @throws Exception
     */
    public function detail(): string
    {
        if (!isset($_GET['name'])) {
            return $this->view('404');
        }

        $zone = [];
        $records = [];
        $types = Record::TYPES;
        $name = $this->escape($_GET['name']);

        // get zone info
        $response = $this->api->getZone($name);
        if ($response->getStatusCode() == HttpResponse::STATUS_ERROR) {
            $this->addFlash('danger', 'Unexpected error has occurred!');
            // @todo log error
        } else {
            $zone = $response->getBody();

            // zone is valid
            if (isset($zone['id'])) {
                // get records info
                $recordsResponse = $this->api->getRecords($name);
                if ($recordsResponse->getStatusCode() == HttpResponse::STATUS_ERROR) {
                    $this->addFlash('danger', 'Unexpected error has occurred!');
                    // @todo log error
                } else {
                    $records = $recordsResponse->getBody()['items'];
                }
            }
        }

        return $this->view('zones/detail', compact('zone', 'records', 'types'));
    }

    /**
     * Create new record page
     * @return string
     * @throws Exception
     */
    public function newRecord(): string
    {
        if (!isset($_GET['name']) || !isset($_GET['type'])) {
            return $this->view('404');
        }

        $name = $this->escape($_GET['name']);
        $type = $this->escape($_GET['type']);

        if (!in_array($type, Record::TYPES)) {
            return $this->view('404');
        }

        $form = new Form('POST');
        $this->recordForm($form, $type);

        if (isset($_POST['submit'])) {
            $form->validate($_POST);

            if ($form->isValid()) {
                $formData = $form->getData();
                $formData['type'] = $type;

                $response = $this->api->createRecord($name, $formData);

                if ($response->getStatusCode() == HttpResponse::STATUS_ERROR) {
                    $this->addFlash('danger', 'Unexpected error has occurred!');
                    // @todo log error
                } else {
                    $result = $response->getBody();

                    // API is kinda inconvenient o.o; not always returning what's in the docs
                    if (isset($result['errors']['content'])) {
                        foreach ($result['errors']['content'] as $error) {
                            $this->addFlash('danger', $error);
                        }
                    } else if (isset($result['errors']['name'])) {
                        // I thought error content is always available
                        foreach ($result['errors']['name'] as $error) {
                            $this->addFlash('danger', $error);
                        }
                    } else if ($result['status'] == 'error') {
                        // this is not in docs (field validation errors)
                        foreach ($result['errors'] as $error) {
                            foreach ($error as $e) {
                                $this->addFlash('danger', $e);
                            }
                        }
                    } else {
                        $this->addFlash('success', 'Record was successfully created!');

                        return $this->redirect('zone_view', compact('name'));
                    }
                }

            }
        }

        return $this->view('zones/record_form', compact('form', 'type', 'name'));
    }

    /**
     * Create record form
     * @param Form $form
     * @param string $type
     */
    private function recordForm(Form $form, string $type): void
    {
        $form->addField(InputField::class, 'name', 'Name', '', [
            'type' => InputField::TYPE_TEXT,
            'rules' => ['required']
        ]);

        $form->addField(InputField::class, 'content', 'Content', '', [
            'type' => InputField::TYPE_TEXT,
            'rules' => ['required']
        ]);

        if (in_array($type, ['MX', 'SRV'])) {
            $form->addField(InputField::class, 'prio', 'Priority', '', [
                'type' => InputField::TYPE_TEXT,
                'rules' => ['required', 'integer']
            ]);
        }

        if ($type == 'SRV') {
            $form->addField(InputField::class, 'port', 'Port', '', [
                'type' => InputField::TYPE_NUMBER,
                'rules' => ['required', 'integer']
            ]);
            $form->addField(InputField::class, 'weight', 'Weight', '', [
                'type' => InputField::TYPE_NUMBER,
                'rules' => ['required', 'integer']
            ]);
        }

        $form->addField(InputField::class, 'ttl', 'Time to live', '', [
            'type' => InputField::TYPE_NUMBER,
            'rules' => ['integer']
        ]);
    }

    /**
     * Delete record
     * @return mixed
     * @throws Exception
     */
    public function deleteRecord()
    {
        if (!isset($_GET['name']) || !isset($_GET['id'])) {
            return $this->view('404');
        }

        $name = $this->escape($_GET['name']);
        $id = $this->escape($_GET['id']);

        $response = $this->api->deleteRecord($name, $id);

        if ($response->getStatusCode() == HttpResponse::STATUS_ERROR) {
            $this->addFlash('danger', 'Unexpected error has occurred!');
            // @todo log error
        } else {
            $result = $response->getBody();
            if (isset($result['message'])) {
                $this->addFlash('danger', $result['message']);
            } else {
                $this->addFlash('success', 'Record was successfully deleted!');
            }
        }

        return $this->redirect('zone_view', compact('name'));
    }
}
