<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GraphicalEditor\GraphicalEditorService;

/**
 * Editor Commands Test
 * @author King James Torres <tcopr.kingjames@gmail.com>
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
    public function testCreateCommand( $rows, $cols )
    {
        $this->assertTrue( $this->editor->create( $rows, $cols ) );
    }

    /**
     *  @dataProvider setColorCommandProvider
     */
    public function testSetColorCommand( $row, $col, $color )
    {
        $this->editor->create( 10, 10 );
        $this->editor->setColor( $row, $col, $color );

        $image = $this->editor->showImage();

        // check if the target pixel coordinate sets the color
        $this->assertEquals( $color, $image[ $row - 1 ][ $col - 1 ] );
    }

    /**
     * [testClearCommand description]
     * @return [type] [description]
     */
    public function testClearCommand() {

        $this->editor->create( 10, 10 );
        $this->editor->setColor( 4, 2, 'C' );

        // get the update table
        $image = $this->editor->showImage();

        // check if the target pixel coordinate sets the color
        $this->assertEquals( 'C', $image[ 4 - 1 ][ 2 - 1 ] );

        // now clear the table
        $this->editor->clear();

        // get the updated table
        $image = $this->editor->showImage();

        // check if the target pixel coordinate sets to default color
        $this->assertEquals( 'O', $image[ 4 - 1 ][ 2 - 1 ] );
    }

    /**
     * [createProvider description]
     * @return [type] [description]
     */
    public function createCommandProvider() 
    {
        return array(
            array( 19, 10 ),
            array( 10, 10 ),
            array( 1, 4 )
        );
    }

    /**
     * [setColorCommandProvider description]
     * @return [type] [description]
     */
    public function setColorCommandProvider() {

        return array(
            array( 2, 3, 'C' ),
            array( 5, 6, 'C' ),
            array( 10, 4, 'C')
        );
    }
}