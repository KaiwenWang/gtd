<?php

class AddBookmarksTable extends Ruckusing_BaseMigration {

	public function up() {
    $bookmark = $this->create_table('bookmark');
    $bookmark->column('staff_id', 'integer');
    $bookmark->column('source', 'string');
    $bookmark->column('alias', 'string');
    $bookmark->column('description', 'string');
    $bookmark->finish();
	}//up()

	public function down() {
    $this->drop_table('bookmark');
	}//down()
}
?>
