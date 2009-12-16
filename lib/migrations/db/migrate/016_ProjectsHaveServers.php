<?php

class ProjectsHaveServers extends Ruckusing_BaseMigration {

	public function up() {
        $this->add_column( "project", "server", "string" ) ;
	}//up()

	public function down() {
        $this->remove_column( "project", "server" );
	}//down()
}
?>
