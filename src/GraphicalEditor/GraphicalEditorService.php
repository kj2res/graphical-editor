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
	public function create( $cols, $rows )
	{
		if( $isValid = $this->_validateTableSize( $rows, $cols ) ) 
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
	public function setColor( $pixelY, $pixelX, $color ) 
	{
		if( $this->_validatePixel( $pixelY, $pixelX ) ) 
		{
			$this->image[ $pixelX - 1 ][ $pixelY - 1 ] = $color;
		}
	}

	/**
	 * [setVerticalSegment Creates Vertical Segment]
	 * @param [type] $pixelX   [description]
	 * @param [type] $pixelY1  [description]
	 * @param [type] $pixelY2  [description]
	 * @param [type] $color [description]
	 */
	public function setVerticalSegment( $pixelY, $pixelX1, $pixelX2, $color ) 
	{
		if( $pixelX1 < $pixelX2 ) 
		{
			for( $x = $pixelX1 - 1; $x <= $pixelX2 - 1; $x++ ) 
			{
				if( $this->_validatePixel( $pixelY, $x + 1 ) ) 
				{
					$this->image[ $x ][ $pixelY - 1 ] = $color;
					$this->image[ $x ][ $pixelY - 1 ] = $color;
				}
			}
		}
	}

	/**
	 * [setHorizontalSegment Creates Horizontal Segment]
	 * @param [type] $pixelY1  [description]
	 * @param [type] $pixelY2  [description]
	 * @param [type] $pixelX   [description]
	 * @param [type] $color [description]
	 */
	public function setHorizontalSegment( $pixelY1, $pixelY2, $pixelX, $color ) 
	{
		if( $pixelY1 < $pixelY2 ) 
		{
			for( $y = $pixelY1 - 1; $y <= $pixelY2 - 1; $y++ ) 
			{
				if( $this->_validatePixel( $y + 1, $pixelX ) ) 
				{
					$this->image[ $pixelX - 1 ][ $y ] = $color;
					$this->image[ $pixelX - 1 ][ $y ] = $color;
				}
			}
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
		if( $this->image && $this->_validatePixel( $pixelY, $pixelX ) ) 
		{
			$region = $this->image[ $pixelX - 1 ][ $pixelY - 1 ];
			$newImage = array();

			foreach ( $this->image as $rowKey => $row ) 
			{
				foreach ( $row as $colKey => $col ) 
				{
					if( $this->_hasTheSameColor( $rowKey, $colKey, $region ) 
						&& $this->_hasCommonSide( $rowKey, $colKey, $region ) )
					{
						$newImage[ $rowKey ][ $colKey ] = $color;
					}
					else 
					{
						$newImage[ $rowKey ][ $colKey ] = $this->image[ $rowKey ][ $colKey ];
					}
				}
			}

			// Now update the image
			$this->image = $newImage;
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
	 * [_validateTableSize Check if the range of pixels is valid]
	 * @param  [type] $rows [description]
	 * @param  [type] $cols [description]
	 * @return [type]       [description]
	 */
	private function _validateTableSize( $cols, $rows ) 
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
	private function _validatePixel( $pixelY, $pixelX ) 
	{
		if( isset( $this->image[ $pixelX - 1 ][ $pixelY - 1 ] ) ) 
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