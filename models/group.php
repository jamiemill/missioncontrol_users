<?php
class Group extends UsersAppModel {

	var $hasMany = array('Users.User');
	
	var $actsAs = array('Acl' => array('type' => 'requester'),'Tree');

	function parentNode(){

		if (!$this->id) {
			return null;
		}

		$data = $this->read();

		if (!$data['Group']['parent_id']){
			return null;
		}
		else {
			// TODO: not sure this is being returned in the right format... check
			//return $data['Group']['parent_id'];
			return array('Group'=>array('id'=>$data['Group']['parent_id']));
		}
	}
	
	
	/**
	* Using a method by Bam Roberts shared at http://www.neilcrookes.com/2009/02/26/get-all-acl-permissions/
	* 
	* Finds all the permissions a specified group has.
	* 
	*  
	*/
	
	
	function permissions($id) {
	    $this->id = $id;
	    $node = $this->node();
	    $aroId = $node[0]['Aro']['id'];

	    $sql = "SELECT DISTINCT alias
		FROM   (SELECT user_id.aro_id,
		               (SELECT CASE
		                         WHEN controler IS NULL
		                         THEN method
		                         WHEN master IS NULL
		                         THEN Concat(controler,'/',method)
		                         ELSE Concat(master,'/',controler,'/',method)
		                       END AS alias
		                FROM   (SELECT id,
		                               `alias` AS method,
		                               (SELECT `alias`
		                                FROM   acos
		                                WHERE  id = t.parent_id) AS controler,
		                               (SELECT `alias`
		                                FROM   acos
		                                WHERE  id = (SELECT `parent_id`
		                                             FROM   acos
		                                             WHERE  id = t.parent_id)) AS `master`
		                        FROM   acos t) aco
		                WHERE  aco.id = u.aco_id
		                        OR aco.id = p.aco_id) AS name,
		               CASE
		                 WHEN u.aco_id = 0
		                       OR u.aco_id IS NULL
		                 THEN p.aco_id
		                 ELSE u.aco_id
		               END AS aco_id,
		               CASE
		                 WHEN u._create = 0
		                       OR u._create IS NULL
		                 THEN p._create
		                 ELSE u._create
		               END AS _create,
		               CASE
		                 WHEN u._read = 0
		                       OR u._read IS NULL
		                 THEN p._read
		                 ELSE u._read
		               END AS _read,
		               CASE
		                 WHEN u._update = 0
		                       OR u._update IS NULL
		                 THEN p._update
		                 ELSE u._update
		               END AS _update,
		               CASE
		                 WHEN u._delete = 0
		                       OR u._delete IS NULL
		                 THEN p._delete
		                 ELSE u._delete
		               END AS _delete
		        FROM   (SELECT 'a'      AS flag,
		                       '$aroId' AS aro_id) user_id
		               LEFT JOIN (SELECT   'a' AS mark1,
		                                   aco_id,
		                                   `_create`,
		                                   `_read`,
		                                   `_update`,
		                                   `_delete`
		                          FROM     `aros_acos` AS `permission`
		                                   LEFT JOIN `aros` AS `aro`
		                                     ON (`permission`.`aro_id` = `aro`.`id`)
		                                   LEFT JOIN `acos` AS `aco`
		                                     ON (`permission`.`aco_id` = `aco`.`id`)
		                          WHERE    `permission`.`aro_id` = '$aroId'
		                          ORDER BY `aco`.`lft`) u
		                 ON u.mark1 = user_id.flag
		               LEFT JOIN (SELECT 'a' AS mark2,
		                                 aco_id,
		                                 `_create`,
		                                 `_read`,
		                                 `_update`,
		                                 `_delete`
		                          FROM   `aros_acos` AS `permission`
		                                 LEFT JOIN `aros` AS `aro`
		                                   ON (`permission`.`aro_id` = `aro`.`id`)
		                                 LEFT JOIN `acos` AS `aco`
		                                   ON (`permission`.`aco_id` = `aco`.`id`)
		                          WHERE  `permission`.`aro_id` = (SELECT id
		                                                          FROM   aros
		                                                          WHERE  id = (SELECT parent_id
		                                                                       FROM   aros
		                                                                       WHERE  id = '$aroId'))) p
		                 ON p.mark2 = user_id.flag
		        WHERE  u._create = 1
		                OR u._read = 1
		                OR u._update = 1
		                OR u._delete = 1
		                OR p._create = 1
		                OR p._read = 1
		                OR p._update = 1
		                OR p._delete = 1) tt
		       LEFT JOIN (SELECT `aco`.`id`,
		                         `aco`.`parent_id`,
		                         `aco`.`model`,
		                         `aco`.`foreign_key`,
		                         `aco`.rght,
		                         `aco`.lft,
		                         CASE
		                           WHEN controler IS NULL
		                           THEN method
		                           WHEN master IS NULL
		                           THEN Concat(controler,'/',method)
		                           ELSE Concat(master,'/',controler,'/',method)
		                         END AS alias
		                  FROM   (SELECT *,
		                                 `alias` AS method,
		                                 (SELECT `alias`
		                                  FROM   acos
		                                  WHERE  id = t.parent_id) AS controler,
		                                 (SELECT `alias`
		                                  FROM   acos
		                                  WHERE  id = (SELECT `parent_id`
		                                               FROM   acos
		                                               WHERE  id = t.parent_id)) AS `master`
		                          FROM   acos t) aco) tmp_aco
		         ON tmp_aco.id = tt.aco_id
		             OR tmp_aco.alias LIKE Concat(tt.name,'%')
	    ";

	    $permissions = $this->query($sql);
	    $permissions = Set::extract('/tmp_aco/alias', $permissions);
	    return $permissions;
	}
	
}
?>
