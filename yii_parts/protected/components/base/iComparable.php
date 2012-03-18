<?php

interface iComparable {

	/**
	 * Get the comparable version of this item, e.g. the hash of a file.
	 * Just make sure that the method for generating the comparable is the
	 * same as the comparison object, otherwise comparisons will fail.
	 * @return string.
	 */
	public function getComparable();

	/**
	 * Get the modified time for this item.
	 * We standardize on UTC time.
	 * @return int
	 */
	public function getModifiedUtcTime();

}
