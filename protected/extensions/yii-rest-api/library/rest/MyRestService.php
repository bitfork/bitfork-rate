<?php
namespace rest;

class MyRestService extends Service
{
    /**
     * @param $data
     * @param array $filterFields
     * @param int $statusCode
     */
    public function sendData($data, array $filterFields = null, $statusCode = 200)
    {
        if ($filterFields !== null && $data !== null) {
            //if (count($data['data'])>1) $filteredData = array('object' => 'list');
            foreach ($filterFields as $field) {
                if (!array_key_exists($field, $data)) {
                    continue;
                }
                $filteredData[$field] = $this->_filterData($data[$field]);
            }
            $data = $filteredData;
        } else {
            $data = $this->_filterData($data);
        }
		$data = array('success'=>true) + $data;

        $this->_send($data, $statusCode);
    }
}
