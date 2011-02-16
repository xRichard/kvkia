<?php
if($_GET['status'] == 'add')
{
    echo "Add part";
}
else if($_GET['status'] == 'adjust')
{
    echo "Adjust part";
}
else if ($_GET['status'] == 'delete')
{
    echo "Delete part";
}
else
{
    echo "test";
}
?>
