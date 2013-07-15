<?php
namespace VehicleFitsMetator;
class DataMapper extends \Metator\Product\DataMapper
{
    function doSelect($select)
    {
        $ids = $this->vafProductIds();
        if(!$ids) {
            return;
        }
        $select->where(sprintf('`id` IN (%s)', implode(',', $ids)));
    }

    function doCount($sql)
    {
        $sql .= ' and 0';
        return $sql;
    }

    function vafProductIds()
    {
        $this->flexibleSearch()->storeFitInSession();
        $productIds = $this->flexibleSearch()->doGetProductIds();
        return $productIds;
    }

    /** @return \VF_FlexibleSearch */
    function flexibleSearch()
    {
        $search = new \VF_FlexibleSearch(new \VF_Schema, new \Zend_Controller_Request_Http);;
        return $search;
    }
}