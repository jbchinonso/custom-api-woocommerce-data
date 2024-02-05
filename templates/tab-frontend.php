<div id="saucal">
            <h1> Enter your Preferences below</h1>
            <form action = "" method = "post">
                <div class="control">
                    <label for="api-preferences">Preferences:
                    <small>comma separated values</small>
                    </label>
                    <input type="text" name="api-preferences" id="api-preferences" value="%s" placeholder="phones,laptops,tablets">
                </div>
                   %s
                <input type="submit" value="Save">
             </form>
             <div class="wrapper">
             <div class="data-row x-header"> <div class="row-header">Header </div><div class="row-data"> Content</div></div>

            <div class="data-row"><div class="row-header">Accept: </div><div class="row-data">%s</div></div>
            <div class="data-row"><div class="row-header">Accept-Encoding: </div><div class="row-data">%s</div></div>
            <div class="data-row"><div class="row-header">Content-Length: </div><div class="row-data">%s</div></div>
            <div class="data-row"><div class="row-header">Content-Type: </div><div class="row-data">%s</div></div>
            <div class="data-row"><div class="row-header">Host: </div><div class="row-data">%s</div></div>
            <div class="data-row"><div class="row-header">User-Agent: </div><div class="row-data">%s</div></div>
            <div class="data-row"><div class="row-header">X-Amzn-Trace-Id: </div><div class="row-data">%s</div></div>

             </div>
             </div>