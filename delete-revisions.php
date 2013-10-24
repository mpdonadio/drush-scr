<?php

$query = new EntityFieldQuery();

$entities = $query->entityCondition('entity_type', 'node', '=')
  ->propertyCondition('status', 1)
  ->propertyOrderBy('nid', 'ASC')
  ->execute();
 
$nids = array_keys($entities['node']);
$ndeleted = 0;

foreach ($nids as $nid) {
  $node = node_load($nid, NULL, TRUE);
  $revisions = array_keys(node_revision_list($node));
  
  if (count($revisions) > 1) {
    print 'nid=' . $node->nid . ' vids=' . join(',', $revisions) . "\n";
    print '  current vid=' . $node->vid. "\n";
    foreach ($revisions as $revision_id) {
      if ($revision_id != $node->vid) {
        print '  deleting vid=' . $revision_id . "\n";
        node_revision_delete($revision_id);
        $ndeleted++;
      }
    }
  }
  else {
    print 'nid=' . $node->nid . ' vid=' . $node->vid . "\n";
  }
}

print $ndeleted . " revisions deleted.\n";
