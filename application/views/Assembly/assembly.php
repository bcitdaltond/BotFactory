    <h1>Assembly and Return</h1>

    <form method="post" action="AssemblyController/assemblyOrReturn">
        {tableTop}
        {tableTorso}
        {tableBottom}
        <div class="buttons">
            <input type="submit" name="assembly" value="Assemble Robot" class="btn btn-secondary btn-lg"/>
            <input type="submit" name="return" value="Return to PRC" class="btn btn-secondary btn-lg"/>
        </div>
    </form>