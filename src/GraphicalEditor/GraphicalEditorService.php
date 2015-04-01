<?php

namespace GraphicalEditor;

/**
 * Editor Commands
 * @author  King James Torres <tcorp.kingjames@gmail.com>
 */
class GraphicalEditorService {

	/**
	 * [$image description]
	 * @var array
	 */
	protected $image = array();

	/**
	 * [$defaultColor description]
	 * @var string
	 */
	protected $defaultColor = 'O';

	/**
	 * [create Create the Image]
	 * @return [type] [description]
	 */
	public function create( $rows, $cols )
	{
		if( $isValid = $this->_validatePixels( $rows, $cols ) ) 
		{
			$image = array();
			$divider = array();

			for( $x = $rows; $x > 0; $x-- ) 
			{
				for( $y = $cols; $y > 0; $y-- ) 
				{
					// Initialize the image color to White (O)
					array_push( $divider, $this->defaultColor );
				}
				array_push( $image, $divider );
				$divider = array();
			}

			$this->image = $image;
			return true;
		}
		return false;
	}

	/**
	 * [setColor Sets the color of the specified Pixel Coordinate]
	 * @param [int] $row   [ pixelX ]
	 * @param [int] $col   [ pixelY ]
	 * @param [string] $color [ The Color to be set ]
	 */
	public function setColor( $row, $col, $color ) 
	{
		if( $this->_validatePixel( $row, $col ) ) 
		{
			$this->image[ $row - 1 ][ $col - 1 ] = $color;
		}
	}

	/**
	 * [setVerticalSegment Creates Vertical Segment]
	 * @param [type] $row   [description]
	 * @param [type] $col1  [description]
	 * @param [type] $col2  [description]
	 * @param [type] $color [description]
	 */
	public function setVerticalSegment( $row, $col1, $col2, $color ) 
	{
		if( $this->_validatePixel( $row, $col1 ) && $this->_validatePixel( $row, $col2 ) ) 
		{
			$this->image[ $row - 1 ][ $col1 - 1 ] = $color;
			$this->image[ $row - 1 ][ $col2 - 1 ] = $color;
		}
	}

	/**
	 * [setHorizontalSegment Creates Horizontal Segment]
	 * @param [type] $col1  [description]
	 * @param [type] $col2  [description]
	 * @param [type] $row   [description]
	 * @param [type] $color [description]
	 */
	public function setHorizontalSegment( $col1, $col2, $row, $color ) 
	{
		if( $this->_validatePixel( $row, $col1 ) && $this->_validatePixel( $row, $col2 ) ) 
		{
			$this->image[ $row - 1 ][ $col1 - 1 ] = $color;
			$this->image[ $row - 1 ][ $col2 - 1 ] = $color;
		}
	}

	/**
	 * [fillRegion description]
	 * @param  [type] $pixelX [description]
	 * @param  [type] $pixelY [description]
	 * @param  [type] $color  [description]
	 * @return [type]         [description]
	 */
	public function fillRegion( $pixelX, $pixelY, $color )
	{
		$region = $this->image[ $pixelX - 1 ][ $pixelY - 1 ];
		
		foreach ( $this->image as $rowKey => $row ) {
			foreach ( $row as $colKey => $col ) {
				if( $this->_hasTheSameColor( $rowKey, $colKey, $region ) 
					&& $this->_hasCommonSide( $rowKey, $colKey, $region ) )
				{
					$this->image[ $rowKey ][ $colKey ] = $color;
				}
			}
		}
	}

	/**
	 * [clear Reset the Image]
	 * @return [type] [description]
	 */
	public function clear() 
	{
		array_walk_recursive( $this->image, function( &$value, $key ) {
			$value = $this->defaultColor;
		});
	}

	/**
	 * [_hasCommonSide description]
	 * @param  [type]  $pixelX [description]
	 * @param  [type]  $pixelY [description]
	 * @param  [type]  $region [description]
	 * @return boolean         [description]
	 */
	private function _hasCommonSide( $pixelX, $pixelY, $region ) 
	{
		$hasCommon = false;
		$directions = array(
			'left'        => array( 'pixelX' => $pixelX, 'pixelY' => $pixelY - 1 ), 
			'right'       => array( 'pixelX' => $pixelX, 'pixelY' => $pixelY + 1 ), 
			'top'         => array( 'pixelX' => $pixelX - 1, 'pixelY' => $pixelY ), 
			'bottom'      => array( 'pixelX' => $pixelX + 1, 'pixelY' => $pixelY ), 
			'topLeft'     => array( 'pixelX' => $pixelX - 1, 'pixelY' => $pixelY - 1 ), 
			'topRight'    => array( 'pixelX' => $pixelX - 1, 'pixelY' => $pixelY + 1 ), 
			'bottomLeft'  => array( 'pixelX' => $pixelX + 1, 'pixelY' => $pixelY - 1 ), 
			'bottomRight' => array( 'pixelX' => $pixelX + 1, 'pixelY' => $pixelY + 1 ), 
		);

		foreach ( $directions as $direction ) 
		{
			$target = isset($this->image[ $direction['pixelX'] ][ $direction['pixelY'] ]) ?
					  $this->image[ $direction['pixelX'] ][ $direction['pixelY'] ] : null;

			if( $target === $region ) {
				$hasCommon = true;
				break;
			}
		}

		return $hasCommon;
	}

	/**
	 * [_hasTheSameColor description]
	 * @param  [type]  $pixelX [description]
	 * @param  [type]  $pixelY [description]
	 * @param  [type]  $region [description]
	 * @return boolean         [description]
	 */
	private function _hasTheSameColor( $pixelX, $pixelY, $region )
	{
		if( $this->image[ $pixelX ][ $pixelY ] === $region )
		{
			return true;
		}
		return false;
	}

	/**
	 * [_validatePixels Check if the range of pixels is valid]
	 * @param  [type] $rows [description]
	 * @param  [type] $cols [description]
	 * @return [type]       [description]
	 */
	private function _validatePixels( $rows, $cols ) 
	{
		if( $cols >= 1 && ($rows <= 250 && $rows >= 1) ) 
		{
			return true;
		}
		return false;
	}

	/**
	 * [_validatePixel Check if specified pixel coordinate exist]
	 * @param  [type] $row [ pixelX ]
	 * @param  [type] $col [ pixelY ]
	 * @return [boolean]
	 */
	private function _validatePixel( $row, $col ) 
	{
		if( isset( $this->image[ $row - 1 ][ $col - 1 ] ) ) 
		{
			return true;
		}
		return false;
	}

	/**
	 * [showImage Get the Image]
	 * @return array The image
	 */
	public function showImage() 
	{
		return $this->image;
	}
}