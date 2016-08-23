<?php

class Content extends MySQLCN {

    function addContent($data) {
        $sql = "INSERT INTO content (`cat_id`,`title`,`description`,`status`,`created_at`, `price`, `published`, `author`, `report_code`)
                VALUES('{$data['cat_id']}','{$data['title']}','{$data['description']}','1',NOW(), '{$data['price']}', '{$data['published']}', '{$data['author']}', '{$data['report_code']}')";
        $result = $this->insert($sql);
        
        $filename = Common::upload_image('image',SLIDER_IMAGE_PATH, $result);
        
        if(!$filename){
            $filename = "";
            }
        
        //udated image field after uploading
            $sql = "UPDATE `content` SET `image` = '{$filename}' WHERE `content_id` = '{$result}'";
            $this->update($sql);
            return $result;
    }

    function editContent($data) {
        
        $sql = "UPDATE `content` SET
                `cat_id`= '{$data['cat_id']}',
                `title`= '{$data['title']}',
                `description` = '{$data['description']}',
                `updated_at` = NOW(),
                `price` = '{$data['price']}',
                `published` = '{$data['published']}',
                `author` = '{$data['author']}',
                `report_code` = '{$data['report_code']}'
                WHERE `content_id` = '{$data['content_id']}'";
              //echo $sql; exit;
        $this->update($sql);
        $filename = Common::upload_image('image', SLIDER_IMAGE_PATH, $data['content_id']);
        
        if (!$filename) {
            $filename = "";
        }
        //udated image field after uploading
         $sql1 = "UPDATE `content` SET `image` = '{$filename}' WHERE `content_id` = '{$data['content_id']}' ";
        $this->update($sql1);
        
        return true;
    }

    function deleteContent($content_id) {

        $sql = "DELETE FROM content WHERE content_id='{$content_id}'";
        $this->delete($sql);
        return true;
    }

    function getContentById($content_id) {
        $sql = "SELECT * FROM `content` WHERE content_id='{$content_id}'";
        $result = $this->select_assoc($sql);
        return $result;
    }

    function DisplayCatCombo($id, $selected) {
        //global $myaction;
        global $content_id;
        global $myTree;

        if ($category_id != 0) {
            $sql = "SELECT * FROM content WHERE parent_id='" . $id . "' AND content_id!='" . $content_id . "' ORDER BY title";
        } else {
            $sql = "SELECT * FROM content WHERE parent_id=$id ORDER BY title";
        }
        $rs = $this->select_assoc($sql);
        foreach ($rs as $key => $value) {
            $s = $value["content_id"] == $selected ? 'selected' : '';
            echo '<option value="' . $value['content_id'] . '" ' . $s . '>';
            $myTree = Array();
            echo $this->getCategoryTree($value["content_id"]);
            echo "</option>\n";
            $this->DisplayCatCombo($value["content_id"], $selected);
        }
    }

    function getCategoryTree($id) {
        global $myTree;
        $sql = "SELECT parent_id,title FROM content WHERE content_id=" . $id;
        $result = $this->select_assoc($sql);
        if ($result) {
            $myV = $result[0]["title"];
            $myTree[] = $myV;
            return $this->getCategoryTree($result[0]["parent_id"]);
        } else {
            return implode(' ==> ', array_reverse($myTree));
        }
    }

    function changeStatus($id) {

        $sql = "SELECT status,content_id FROM `content` WHERE `content_id`='{$id}'";
        $result = $this->select_assoc($sql);
        $status = $result[0]["status"];

        if ($status == '0') {
            $sql1 = "UPDATE `content` SET `status` = '1' WHERE `content_id`='{$id}'";
            $this->update($sql1);
        }
        if ($status == '1') {
            $sql1 = "UPDATE `content` SET `status` = '0' WHERE `content_id`='{$id}'";
            $this->update($sql1);
        }

        //send mail to content when account is activated/deactivated
        //$this->sendContentMailForStatus($id);

        $sql = "SELECT status,content_id FROM `content` WHERE `content_id`='{$id}' ORDER BY title";
        $resultAfter = $this->select_assoc($sql);
        return $resultAfter;
    }

    function changeUpcomingStatus($content_id) {

        $sql = "SELECT isupcoming, content_id FROM `content` WHERE `content_id`='{$content_id}'";
        $result = $this->select_assoc($sql);
        $status = $result[0]["isupcoming"];

        if ($status == '0') {
            $sql1 = "UPDATE `content` SET `isupcoming` = '1' WHERE `content_id`='{$content_id}'";
            $this->update($sql1);
        }
        if ($status == '1') {
            $sql1 = "UPDATE `content` SET `isupcoming` = '0' WHERE `content_id`='{$content_id}'";
            $this->update($sql1);
        }
        $sql = "SELECT isupcoming, content_id FROM `content` WHERE `content_id`='{$content_id}' LIMIT 1";
        $resultAfter = $this->select_assoc($sql);
        return $resultAfter;
    }
    
    public function fetchReportTree($parent = 0, $spacing = '', $user_tree_array = '') {
        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = "SELECT content_id, title FROM content ORDER BY content_id ASC";
        $queryRes = $this->select_assoc($sql);
        if (count($queryRes) > 0) {
            foreach ($queryRes as $key => $row) {
                $user_tree_array[] = array("id" => $row['content_id'], "name" => $spacing . $row['title']);
            }
        }
        return $user_tree_array;
    }
//ends the class over here
}

?>

==============
/***
New Code
****/

<?php

class Content extends MySQLCN {

    function addContent($data) {
        $sql = "INSERT INTO content (`cat_id`,`title`,`description`,`descriptions`,`status`,`created_at`, `price`, `published`, `author`, `report_code`)
                VALUES('{$data['cat_id']}','{$data['title']}','{$data['description']}','1',NOW(),'{$data['descriptions']}','1',NOW(),'{$data['price']}', '{$data['published']}', '{$data['author']}', '{$data['report_code']}')";
        $result = $this->insert($sql);
        
        $filename = Common::upload_image('image',SLIDER_IMAGE_PATH, $result);
        
        if(!$filename){
            $filename = "";
            }
        
        //udated image field after uploading
            $sql = "UPDATE `content` SET `image` = '{$filename}' WHERE `content_id` = '{$result}'";
            $this->update($sql);
            return $result;
    }

    function editContent($data) {
        
        $sql = "UPDATE `content` SET
                `cat_id`= '{$data['cat_id']}',
                `title`= '{$data['title']}',
                `description` = '{$data['description']}',
                `descriptions` = '{$data['descriptions']}',
                `updated_at` = NOW(),
                `price` = '{$data['price']}',
                `published` = '{$data['published']}',
                `author` = '{$data['author']}',
                `report_code` = '{$data['report_code']}'
                WHERE `content_id` = '{$data['content_id']}'";
              //echo $sql; exit;
        $this->update($sql);
        $filename = Common::upload_image('image', SLIDER_IMAGE_PATH, $data['content_id']);
        
        if (!$filename) {
            $filename = "";
        }
        //udated image field after uploading
         $sql1 = "UPDATE `content` SET `image` = '{$filename}' WHERE `content_id` = '{$data['content_id']}' ";
        $this->update($sql1);
        
        return true;
    }

    function deleteContent($content_id) {

        $sql = "DELETE FROM content WHERE content_id='{$content_id}'";
        $this->delete($sql);
        return true;
    }

    function getContentById($content_id) {
        $sql = "SELECT * FROM `content` WHERE content_id='{$content_id}'";
        $result = $this->select_assoc($sql);
        return $result;
    }

    function DisplayCatCombo($id, $selected) {
        //global $myaction;
        global $content_id;
        global $myTree;

        if ($category_id != 0) {
            $sql = "SELECT * FROM content WHERE parent_id='" . $id . "' AND content_id!='" . $content_id . "' ORDER BY title";
        } else {
            $sql = "SELECT * FROM content WHERE parent_id=$id ORDER BY title";
        }
        $rs = $this->select_assoc($sql);
        foreach ($rs as $key => $value) {
            $s = $value["content_id"] == $selected ? 'selected' : '';
            echo '<option value="' . $value['content_id'] . '" ' . $s . '>';
            $myTree = Array();
            echo $this->getCategoryTree($value["content_id"]);
            echo "</option>\n";
            $this->DisplayCatCombo($value["content_id"], $selected);
        }
    }

    function getCategoryTree($id) {
        global $myTree;
        $sql = "SELECT parent_id,title FROM content WHERE content_id=" . $id;
        $result = $this->select_assoc($sql);
        if ($result) {
            $myV = $result[0]["title"];
            $myTree[] = $myV;
            return $this->getCategoryTree($result[0]["parent_id"]);
        } else {
            return implode(' ==> ', array_reverse($myTree));
        }
    }

    function changeStatus($id) {

        $sql = "SELECT status,content_id FROM `content` WHERE `content_id`='{$id}'";
        $result = $this->select_assoc($sql);
        $status = $result[0]["status"];

        if ($status == '0') {
            $sql1 = "UPDATE `content` SET `status` = '1' WHERE `content_id`='{$id}'";
            $this->update($sql1);
        }
        if ($status == '1') {
            $sql1 = "UPDATE `content` SET `status` = '0' WHERE `content_id`='{$id}'";
            $this->update($sql1);
        }

        //send mail to content when account is activated/deactivated
        //$this->sendContentMailForStatus($id);

        $sql = "SELECT status,content_id FROM `content` WHERE `content_id`='{$id}' ORDER BY title";
        $resultAfter = $this->select_assoc($sql);
        return $resultAfter;
    }

    function changeUpcomingStatus($content_id) {

        $sql = "SELECT isupcoming, content_id FROM `content` WHERE `content_id`='{$content_id}'";
        $result = $this->select_assoc($sql);
        $status = $result[0]["isupcoming"];

        if ($status == '0') {
            $sql1 = "UPDATE `content` SET `isupcoming` = '1' WHERE `content_id`='{$content_id}'";
            $this->update($sql1);
        }
        if ($status == '1') {
            $sql1 = "UPDATE `content` SET `isupcoming` = '0' WHERE `content_id`='{$content_id}'";
            $this->update($sql1);
        }
        $sql = "SELECT isupcoming, content_id FROM `content` WHERE `content_id`='{$content_id}' LIMIT 1";
        $resultAfter = $this->select_assoc($sql);
        return $resultAfter;
    }
    
    public function fetchReportTree($parent = 0, $spacing = '', $user_tree_array = '') {
        if (!is_array($user_tree_array))
            $user_tree_array = array();

        $sql = "SELECT content_id, title FROM content ORDER BY content_id ASC";
        $queryRes = $this->select_assoc($sql);
        if (count($queryRes) > 0) {
            foreach ($queryRes as $key => $row) {
                $user_tree_array[] = array("id" => $row['content_id'], "name" => $spacing . $row['title']);
            }
        }
        return $user_tree_array;
    }
//ends the class over here
}

?>
