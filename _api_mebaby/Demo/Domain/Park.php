<?php
/**
 *
 */

class Domain_Park
{
    /**
     * @param $plateNumber
     */
    public function getParkEntry($plateNumber)
    {
        $parkList = new Model_Park();

        $resource = $parkList->getLastEntryAcs($plateNumber);

        return $resource;
    }


    /**
     * @param $plateNumber
     * @param $outTime
     */
    public function getParkOutTime($plateNumber, $outTime)
    {
        $parkOut = new Model_Park();

        $resource = $parkOut->getParkNumberOuterTime($plateNumber, $outTime);

        return $resource;
    }
}
