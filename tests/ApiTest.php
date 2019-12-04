<?php
declare(strict_types=1);

namespace Vms;

class ApiTest extends Tests\TestCase
{

    const TEST_MESSAGE = "PHP SDK Test";

    public function testOptions(): void
    {
        $options = Options::fetch();

        $this->assertTrue($options->systemOk);
        $this->assertTrue($options->dbOk);
        $this->assertGreaterThan(1, $options->currencies->count());
        $this->assertGreaterThan(1, $options->categories->count());
    }

    /*
    public function testSetDefaultImage(): void
    {
        $imageId = "1560452267_itxo.png";
        $valuationId = "5d0519851490bb63ec62ae3f";

        $image = Images::fetch($imageId);

        $image->setDefault($valuationId);
    }
    */

    public function testUploadImage(): void
    {
        $testFile1 = __DIR__ . '/data/moo.jpg';
        //$testFile2= __DIR__ . '/data/foo.jpg'; // todo causing payload to big error

        $images = Images::create([$testFile1]);
        $this->assertEquals(1, count($images->toList()));
    }

    public function testFetchImage(): void
    {
        $image = Images::fetch("1560452267_itxo.png");

        $this->assertEquals($image->buffer->getContentType(), "image/png");
        $this->assertEquals($image->id, "1560452267_itxo.png");
    }

    public function testFetchAllImages(): void
    {
        $testFile = '/tmp/test.zip';

        if (file_exists($testFile)) {
            unlink($testFile);
        }

        $buffer = Images::fetchZip("5d0519851490bb63ec62ae3f", ["api_key" => $_ENV['VMS_ADMIN_API_KEY']]);
        $buffer->saveTo($testFile);

        $this->assertFileExists($testFile);
    }

    public function testFetchValuation(): void
    {
        $valuation = Valuation::fetch("5d0519851490bb63ec62ae3f");
        $this->assertEquals("5d0519851490bb63ec62ae3f", $valuation->id);
    }

    public function testFetchAllValuations(): void
    {
        $valuations = Valuation::all();
        $this->assertGreaterThan(1, $valuations->count());
    }

    public function testCreateValuation(): void
    {

        $testFile1 = __DIR__ . '/data/moo.jpg';
        $images = Images::create([$testFile1]);

        $options = Options::fetch();

        $category = $options->categories->getIterator()->current();
        $currency = $options->currencies->getIterator()->current();

        $valuation = Valuation::create([
            'title' => self::TEST_MESSAGE,
            'userDescription' => self::TEST_MESSAGE,
            'category' => $category,
            'type' => Valuation::TYPE_EXPRESS,
            'images' => $images,
            'dimensions' => [
                'width' => 100,
                'height' => 200,
                'length' => 90,
                'depth' => 20,
                'unit' => Valuation::UNIT_CM
            ],
            'currency' => $currency
        ]);

        $this->assertTrue(is_string($valuation->id) && strlen($valuation->id) > 0);
        $this->assertEquals(self::TEST_MESSAGE, $valuation->title);
        $this->assertEquals(self::TEST_MESSAGE, $valuation->userDescription);
    }
}
