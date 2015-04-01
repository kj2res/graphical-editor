<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GraphicalEditor\GraphicalEditorService;

/**
 * Editor Commands Test
 * @author King James Torres <tcorp.kingjames@gmail.com>
 */
class GraphicalEditorTest extends PHPUnit_Framework_TestCase {

    /**
     * [$editor description]
     * @var [type]
     */
    private $editor;

    /**
     * [setUp description]
     */
    public function setUp() 
    {
        $this->editor = new GraphicalEditorService();
    }
    
    /**
     *  @dataProvider createCommandProvider
     */
    public function testCreateCommand( $cols, $rows )
    {
        $this->assertTrue( $this->editor->create( $cols, $rows ) );
    }

    /**
     *  @dataProvider setColorCommandProvider
     */
    public function testSetColorCommand( $pixelY, $pixelX, $color )
    {
        $this->editor->create( 5, 6 );
        $this->editor->setColor( $pixelY, $pixelX, $color );

        $image = $this->editor->showImage();

        // check if the target pixel coordinate sets the color
        $this->assertEquals( $color, $image[ $pixelX - 1 ][ $pixelY - 1 ] );
    }

    /**
     * [testClearCommand description]
     * @return [type] [description]
     */
    public function testClearCommand() 
    {
        $this->editor->create( 5, 6 );
        $this->editor->setColor( 2, 3, 'C' );

        // get the update table
        $image = $this->editor->showImage();

        // check if the target pixel coordinate sets the color
        $this->assertEquals( 'C', $image[ 2 ][ 1 ] );

        // now clear the table
        $this->editor->clear();

        // get the updated table
        $image = $this->editor->showImage();

        // check if the target pixel coordinate sets to default color
        $this->assertEquals( 'O', $image[ 2 ][ 1 ] );
    }

    /**
     *  @dataProvider setVerticalSegmentProvider
     */
    public function testSetVerticalSegmentCommand( $pixelY, $pixelX1, $pixelX2, $color ) 
    {
        $this->editor->create( 5, 6 );
        $this->editor->setVerticalSegment( $pixelY, $pixelX1, $pixelX2, $color );

        $image = $this->editor->showImage();

        for( $x = $pixelX1 - 1; $x <= $pixelX2 - 1; $x++ ) {

            // check if the target pixel coordinate sets the color
            $this->assertEquals( $color, $image[ $x ][ $pixelY - 1 ] ); // rows
        }
    }

    /**
     *  @dataProvider setHorizontalSegmentProvider
     */
    public function testSetHorizontalSegmentCommand( $pixelY1, $pixelY2, $pixelX, $color ) 
    {
        $this->editor->create( 5, 6 );
        $this->editor->setHorizontalSegment( $pixelY1, $pixelY2, $pixelX, $color );

        $image = $this->editor->showImage();

        for( $y = $pixelY1 - 1; $y <= $pixelY2 - 1; $y++ ) {

            // check if the target pixel coordinate sets the color
            $this->assertEquals( $color, $image[ $pixelX - 1 ][ $y ] ); // cols
        }
    }

    /**
     *  @dataProvider fillRegionProvider
     */
    public function testfillRegion( $row, $col, $color ) 
    {
        $this->editor->create( 5, 6 );
        $this->editor->fillRegion( $row, $col, $color );

        $image = $this->editor->showImage();

        foreach ( $image as $rowKey => $row ) 
        {
            foreach ( $row as $colKey => $col ) 
            {
                $this->assertEquals( $color, $col );
            }
        }
    }

    /**
     * [createProvider description]
     * @return [type] [description]
     */
    public function createCommandProvider() 
    {
        return array(
            array( 5, 6 ),
        );
    }

    /**
     * [setColorCommandProvider description]
     * @return [type] [description]
     */
    public function setColorCommandProvider() 
    {
        return array(
            array( 2, 3, 'A' )
        );
    }

    /**
     * [setVerticalSegmentProvider description]
     * @return [type] [description]
     */
    public function setVerticalSegmentProvider() 
    {
        return array(
            array( 2, 3, 4, 'W' )
        );
    }

    /**
     * [setHorizontalSegmentProvider description]
     * @return [type] [description]
     */
    public function setHorizontalSegmentProvider() 
    {
        return array(
            array( 3, 4, 2, 'Z' )
        );
    }

    /**
     * [fillRegionProvider description]
     * @return [type] [description]
     */
    public function fillRegionProvider() 
    {
        return array(
            array( 1, 1, 'C' )
        );
    }
}