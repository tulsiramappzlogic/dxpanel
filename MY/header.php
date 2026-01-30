<header class="bg-white border-bottom py-2 py-md-3 box-shadow-1">
  <div class="container">
    <!-- Top row: Social icons, Logo, Auth buttons -->
    <div class="row align-items-center g-2 g-md-3">
      <!-- Social Icons - Left Column -->
      <div class="col-4 col-lg-3 text-start">
        <div class="social-icons d-flex flex-wrap">
          <a href="https://www.facebook.com/people/MalaysiaPolls/61586494846051/" class="me-2 me-md-3" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://in.linkedin.com/company/dataxing-digital" class="me-2 me-md-3" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- Logo - Center Column -->
      <div class="col-4 col-lg-6 text-center py-2 py-sm-0">
        <a href="/">
          <img
            src="./image/MalaysiaPolls Logo.png"
            alt="MalaysiaPolls Logo"
            class="brand-logo"
            style="max-width: 100%; height: auto;" />
        </a>
      </div>

      <!-- Auth Buttons - Right Column (Desktop) -->
      <div class="col-4 col-lg-3 text-center text-end d-none d-md-block">
        <div class="d-flex justify-content-end align-items-center gap-2">
          <a href="#" class="btn-auth">
            Login
            <span class="icon-circle bg-uk-red">
              <i class="fas fa-angle-double-right"></i>
            </span>
          </a>
          <a href="./signup.php" class="btn-auth">
            Sign Up
            <span class="icon-circle bg-uk-blue">
              <i class="fas fa-angle-double-right"></i>
            </span>
          </a>
        </div>
      </div>

      <!-- Mobile/Tablet Menu Button -->
      <div class="col-4 col-lg-3 text-center text-end d-md-none">
        <button class="btn btn-outline-secondary rounded-pill" type="button" id="authMenuToggle" style="border: 1px solid rgba(88, 89, 91, 1); padding: 6px 16px;">
          <i class="fas fa-bars"></i> Menu
        </button>
      </div>
    </div>

    <!-- Mobile/Tablet Menu (Hidden by default) -->
    <div class="row d-md-none mt-2" id="authMenuDropdown" style="display: none;">
      <div class="col-12">
        <div class="bg-light rounded p-3 d-flex flex-column gap-2">
          <a href="#" class="btn-auth w-100 text-start">
            <i class="fas fa-sign-in-alt me-2"></i>Login
            <span class="icon-circle bg-uk-red ms-auto">
              <i class="fas fa-angle-double-right"></i>
            </span>
          </a>
          <a href="./signup.php" class="btn-auth w-100 text-start">
            <i class="fas fa-user-plus me-2"></i>Sign Up
            <span class="icon-circle bg-uk-blue ms-auto">
              <i class="fas fa-angle-double-right"></i>
            </span>
          </a>
        </div>
      </div>
    </div>
  </div>
</header>