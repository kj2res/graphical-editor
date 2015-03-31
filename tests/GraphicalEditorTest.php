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

        $image = $this->editor->getImage();

        // check if the target pixel coordinate sets the color
        $this->assertEquals( $image[ $row - 1 ][ $col - 1 ], $color );
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