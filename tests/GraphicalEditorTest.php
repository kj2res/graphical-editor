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
}