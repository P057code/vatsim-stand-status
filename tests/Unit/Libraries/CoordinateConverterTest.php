<?php


namespace Tests\Unit\Libraries;


use CobaltGrid\VatsimStandStatus\Libraries\CAACoordinateConverter;
use CobaltGrid\VatsimStandStatus\Libraries\CoordinateConverter;
use Tests\TestCase;

class CoordinateConverterTest extends TestCase
{
    public function testItCanConvertCAACoordinates()
    {
        $latitude = "510917.35N";
        $longitude1 = "0000953.33W";
        $longitude2 = "0000953.33E";

        $converter = new CAACoordinateConverter($latitude, $longitude1);
        $converter2 = new CAACoordinateConverter($latitude, $longitude2);
        $this->assertEquals(51.154819444444444, $converter->latitudeToDecimal());
        $this->assertEquals(-0.1648138888888889, $converter->longitudeToDecimal());
        $this->assertEquals(0.1648138888888889, $converter2->longitudeToDecimal());
    }

    public function testDMSConversion()
    {
        $class = new class extends CoordinateConverter{
            public function latitudeToDecimal()
            {
                return $this->convertDMSToDecimal(50, 10, 10);
            }

            public function longitudeToDecimal()
            {
                return $this->convertDMSToDecimal(-50, 10, 10);
            }
        };

        $this->assertEquals(50.169444444444444, $class->latitudeToDecimal());
        $this->assertEquals(-50.169444444444444, $class->longitudeToDecimal());
    }
}