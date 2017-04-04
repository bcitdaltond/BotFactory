<h1>Manage BotFactory</h1>
<div class="homepage-content">
    <h2>Register</h2><br>
        <form method ="POST" action="/ManageController/registerme">
            <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="password"><br>
            </div>
            <button type="submit" class="btn btn-success btn-block">Register</button>
        </form> <br>
        <div class="text-center">{message}</div>
    <hr>

    <h2>Ship Robots</h2>
        <form method="post" action="/ManageController/ship">
            {tableRobots}
            <br><br>
                <button type="submit" class="btn btn-primary btn-block">Ship Robot(s)</button>
        </form> <br>
    <hr>

    <h2>Reboot</h2>
        <form method ="POST" action="/ManageController/rebootme">
            <button type="submit" class="btn btn-danger btn-block">Reboot</button>
        </form> <br>
        <div class="text-center">{message_reboot}</div>
    <hr>
</div>