<div class="well span9"> 
    <form class="form-horizontal">
        <fieldset>
          <legend>Bot Info</legend>
          <div class="control-group">
            <label class="control-label">Name</label>
            <div class="controls">
              <input class="span6" type="text" placeholder="Bot Name">      
            </div>
            
          </div>
          <div class="control-group">
            <label class="control-label">Server</label>
            <div class="controls">
              <input class="span6" type="text">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Server Auth:</label>
            <div class="controls">
                <input type="text" class="input-large" placeholder="Username (Optional)">
                <input type="password" class="input-large" placeholder="Password  (Optional)">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="prependedInput">Channel</label>
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on">#</span>
                <input class="span5" id="prependedInput" size="16" type="text">
              </div>
              
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label" for="optionsCheckboxList">Commands</label>
            <div class="controls">
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList1" value="option1">
                !say - Says message in the specified IRC channel (<a href="#">?</a>)
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList2" value="option2">
                !poke - Pokes the specified IRC user. (<a href="#">?</a>)
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList3" value="option3">
                !join - Joins the specified channel. (<a href="#">?</a>)
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList3" value="option3">
                !part - Parts the specified channel. (<a href="#">?</a>)
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList3" value="option3">
                !timeout - Bot leaves for the specified number of seconds. (<a href="#">?</a>)
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList3" value="option3">
                !restart - Quits and restarts the script. (<a href="#">?</a>)
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList3" value="option3">
                !quit - Quits and stops the script. (<a href="#">?</a>)
              </label>
              <p class="help-block"><strong>Note:</strong> More commands can be added in the <a href="command.php">command manager</a>.</p>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="reset" class="btn">Cancel</button>
          </div>
        </fieldset>
      </form>
</div>