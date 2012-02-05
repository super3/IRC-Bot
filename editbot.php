<?php include_once('header.php'); ?>
<div class="span3">
    <?php $_GET['page'] = 'bot'; include_once('sidebar.php'); ?>
</div>
<div class="well span9"> 
    <form class="form-horizontal">
        <fieldset>
          <legend>Add/Edit Bot</legend>
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
                Option one is this and that—be sure to include why it's great
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList2" value="option2">
                Option two can also be checked and included in form results
              </label>
              <label class="checkbox">
                <input type="checkbox" name="optionsCheckboxList3" value="option3">
                Option three can—yes, you guessed it—also be checked and included in form results
              </label>
              <p class="help-block"><strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.</p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label">Radio buttons</label>
            <div class="controls">
              <label class="radio">
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                Option one is this and that—be sure to include why it's great
              </label>
              <label class="radio">
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                Option two can is something else and selecting it will deselect option one
              </label>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="reset" class="btn">Cancel</button>
          </div>
        </fieldset>
      </form>
</div>
<?php include_once('footer.php'); ?>