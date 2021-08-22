<div class="container">
    <h2 style="margin-top: 0;">
        <small>Selamat datang</small>
        <br />
        <?php echo $this->session->userdata('nama') ?>
        <sup>
            <small>( <?php echo $this->session->userdata('username') ?> )</small>
        </sup>
    </h2>
    <hr />

    <div class="form-group">
        <label>Role</label>
        <br />
        <?php echo ucwords(str_replace("_", " ", $this->session->userdata('role'))) ?>
    </div>
</div>