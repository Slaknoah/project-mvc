<?php
/** @var Task [] $tasks */

use app\core\Application;
use app\core\Pagination;
use app\models\Task;

$this->title = 'Tasks';

// Set current orders status
$sortVal = 'default';
if ( isset( $_GET['order_by'] ) && isset( $_GET['order_dir'] ) ) {
    $orderBy = $_GET['order_by'] == 'is_completed' ? 'status' : $_GET['order_by'];
    $sortVal = implode('_', [$orderBy, $_GET['order_dir']]);
}
?>
<h1 class="mb-4">Tasks</h1>

<a type="button" class="btn btn-primary float-end mb-3" href="/add-task">Add task</a>

<div class="mb-3">
    <select class="form-select" onchange="handleSort()" id="sort">
        <option <?php echo ($sortVal === 'default') ? 'selected': '' ?> value="default">Sort by</option>
        <option <?php echo ($sortVal === 'name_asc') ? 'selected': '' ?> value="name_asc">Name(asc)</option>
        <option <?php echo ($sortVal === 'name_desc') ? 'selected': '' ?> value="name_desc">Name(desc)</option>
        <option <?php echo ($sortVal === 'email_asc') ? 'selected': '' ?> value="email_asc">Email(asc)</option>
        <option <?php echo ($sortVal === 'email_desc') ? 'selected': '' ?> value="email_desc">Email(desc)</option>
        <option <?php echo ($sortVal === 'status_asc') ? 'selected': '' ?> value="status_asc">Status(asc)</option>
        <option <?php echo ($sortVal === 'status_desc') ? 'selected': '' ?> value="status_desc">Status(desc)</option>
    </select>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Task</th>
        <th scope="col">Status</th>
        <?php if (!Application::isGuest()): ?>
            <th scope="col"></th>
        <?php endif; ?>
    </tr>
    </thead>
    <?php if (is_array($tasks['data']) && count($tasks['data']) > 0): ?>
    <tbody>
        <?php foreach ($tasks['data'] as $task): ?>
        <tr>
            <th scope="row"><?php echo $task->id; ?></th>
            <td><?php echo $task->name; ?></td>
            <td><?php echo $task->email; ?></td>
            <td><?php echo $task->title; ?></td>
            <td>
                <input <?php echo ($task->is_completed) ? 'checked' : ''; ?> disabled class="form-check-input" type="checkbox" value="">
            </td>
            <?php if (!Application::isGuest()): ?>
                <td>
                    <a class="btn btn-primary" href="/edit-task?task_id=<?php echo $task->id; ?>">Edit</a>
                </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php else: ?>
    <tbody>
        <tr>
            <th colspan="5">No task added yet</th>
        </tr>
    </tbody>
    <?php endif; ?>
</table>

<?php
$page = $tasks['current_page'];
$page_result_count = is_array($tasks['data']) ? count($tasks['data']) : 0;
$isShowPagination = $page_result_count > 0 && ( $page_result_count < $tasks['total'] );
if ($isShowPagination): ?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php echo Pagination::create(
                $page,
                $tasks['total_pages'] ,
                1,
                '<li class="page-item"><a class="page-link" href="%s">%s</a></li>',
                '<li aria-current="page" class="page-item active"><span class="page-link">%d</span></li>',
                '<li class="page-item"><span class="page-link">...</span></li>'
        )
        ?>
    </ul>
</nav>
<?php endif; ?>

<script>
    function handleSort(e) {
        const sort  = document.getElementById("sort");
        const val   = sort.value;
        const url   = new URL(window.location.href);
        const params= url.searchParams;

        switch (val) {
            case 'name_asc':
                params.set('order_by', 'name');
                params.set('order_dir', 'asc');
                params.delete('page');
                break;
            case 'name_desc':
                params.set('order_by', 'name');
                params.set('order_dir', 'desc');
                break;
            case 'email_desc':
                params.set('order_by', 'email');
                params.set('order_dir', 'desc');
                params.delete('page');
                break;
            case 'email_asc':
                params.set('order_by', 'email');
                params.set('order_dir', 'asc');
                params.delete('page');
                break;
            case 'status_asc':
                params.set('order_by', 'is_completed');
                params.set('order_dir', 'asc');
                params.delete('page');
                break;
            case 'status_desc':
                params.set('order_by', 'is_completed');
                params.set('order_dir', 'desc');
                params.delete('page');
                break;
            case 'default':
                params.delete('order_by');
                params.delete('order_dir');
                params.delete('page');
                break;
        }
        url.search = params.toString();

        window.location = url.toString();
    }
</script>
