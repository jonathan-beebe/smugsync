<?php

interface iSyncable {

	/**
	 * Is this item newer than the given time?
	 * @return boolean
	 */
	public function isNewerThan($time);

	/**
	 * Is this item equal to the comparison value?
	 * @return boolean
	 */
	public function isEqualTo($compare);

}
