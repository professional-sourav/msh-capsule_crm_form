<div id="msh-capsule-integration-form">

    <form role="form" method="POST" id="mshcp_form">
        
        <!-- First Name -->
        <div class="mshcp-form-group">
            <label for="mshcp_first_name"><?php echo __("First name", $this->plugin_name ) ?></label>
            <input type="text" name="mshcp_first_name" id="mshcp_first_name" class="mshcp-form-field" required>
        </div>

        <!-- Last Name -->
        <div class="mshcp-form-group">
            <label for="mshcp_last_name"><?php echo __("Last name", $this->plugin_name ) ?></label>
            <input type="text" name="mshcp_last_name" id="mshcp_last_name" class="mshcp-form-field" required>
        </div>

        <!-- Job Title -->
        <div class="mshcp-form-group">
            <label for="mshcp_job_title"><?php echo __("Job Title", $this->plugin_name ) ?></label>
            <input type="text" name="mshcp_job_title" id="mshcp_job_title" class="mshcp-form-field" required>
        </div>

        <!-- Company -->
        <div class="mshcp-form-group">
            <label for="mshcp_company"><?php echo __("Company", $this->plugin_name ) ?></label>
            <input type="text" name="mshcp_company" id="mshcp_company" class="mshcp-form-field" required>
        </div>

        <!-- Email -->
        <div class="mshcp-form-group">
            <label for="mshcp_email"><?php echo __("Email", $this->plugin_name ) ?></label>
            <input type="email" name="mshcp_email" id="mshcp_email" class="mshcp-form-field" required>
        </div>

        <!-- Phone Number -->
        <div class="mshcp-form-group">
            <label for="mshcp_phone_number"><?php echo __("Phone Number", $this->plugin_name ) ?></label>
            <input type="text" name="mshcp_phone_number" id="mshcp_phone_number" class="mshcp-form-field">
        </div>

        <!-- I am interested in -->
        <div class="mshcp-form-group">
            <label for="mshcp_interested_in"><?php echo __("I am interested in", $this->plugin_name ) ?></label>
            <select name="mshcp_interested_in" id="mshcp_interested_in">
                <option value=""><?php echo __("Select option", $this->plugin_name ) ?></option>                
                <option value="Edible film"><?php echo __("Soluble films", $this->plugin_name ) ?></option>
                <option value="Edible film"><?php echo __("Edible film", $this->plugin_name ) ?></option>
                <option value="Fragrance microencapsulates"><?php echo __("Fragrance microencapsulates", $this->plugin_name ) ?></option>
                <option value="Vitamin microcapsules"><?php echo __("Vitamin microcapsules", $this->plugin_name ) ?></option>
                <option value="Resin"><?php echo __("Resin", $this->plugin_name ) ?></option>
            </select>
        </div>

        <!-- Policy -->
        <div class="mshcp-form-group">
            <label for="mshcp_accept_policy">
                <input type="checkbox" name="mshcp_accept_policy" id="mshcp_accept_policy" value="true" class="mshcp-form-option-field" required> 
                <?php echo __("I accept Xampla's privacy policy", $this->plugin_name ) ?>
            </label>
        </div>

        <button type="submit" class="mshcp-form-button-primary"><?php echo __("Submit", $this->plugin_name ) ?></button>
        
    </form>

</div>