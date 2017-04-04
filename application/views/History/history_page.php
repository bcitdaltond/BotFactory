<br>
<script>
    window.onload = function () {
        {sort_script}
    };
</script>
<br><br>
<h1>History View</h1>

<div id="body">
    {pagination}
    <div class="col-xs-12 text-center">
        <form method="post" action="">
            <div class="col-sm-6">
                <select class="form-control" name="order" id="order">
                    <option value="stamp">Date</option>
                    <option value="category">Category</option>
                </select>
            </div>
            <div class="col-sm-6">
                <input class="btn btn-outline-primary" type="submit" value="Sort/Filter" />
            </div>
        </form>
    </div>
    <br><hr>
    <table class="table">
      <thead class="thead-inverse">
         <tr>
            <th>Date</th>
            <th>Category</th>
            <th>Description</th>
            <th>Amount</th>
         </tr>
      </thead>
      <tbody>
         {history}
         <tr>
            <td>
                {date}
            </td>
            <td>
                {category}
            </td>
            <td>
                {description}
            </td>
            <td>
              {amount}
            </td>
         </tr>
         {/history}
      </tbody>
 </table>
</div>