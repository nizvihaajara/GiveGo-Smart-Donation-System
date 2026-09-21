<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role'];
$name = $user['name'];
$email = $user['email'];
$status = $user['status'] ?? 'pending';

function isMenu($pageName) {
    return '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GiveGo</title>
    
    <!-- CSS styles -->
    <link rel="stylesheet" href="css/styles.css?v=126.0">
    <link rel="stylesheet" href="css/dashboard.css?v=126.0">
    

    
    <!-- Firebase Compat SDKs (CDN) -->
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-firestore-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-storage-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-analytics-compat.js"></script>
    <script>
        window.__SERVER_USER__ = <?php echo json_encode($user); ?>;
    </script>
</head>
<body>

    <div class="dashboard-container">
        
        <!-- SIDEBAR NAVIGATION -->
        <aside class="sidebar">
            <div>
                <!-- Brand logo area -->
                <div class="brand-section">
                    <img src="uploads/logo.png" alt="GiveGo Logo" class="brand-logo-img-sidebar">
                </div>
                
                <!-- Role-based navigation lists -->
                <nav>
                    <ul class="menu-list" id="sidebarMenuList">
                        <li class="menu-item active">
                            <a href="#overview">Overview</a>
                        </li>
                        
                        <?php if ($status === 'verified' || $role === 'admin'): ?>
                            <?php if ($role === 'admin'): ?>
                                <li class="menu-item">
                                    <a href="#users">Accounts</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#approvals">Approvals</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#inquiries">Inquiries</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#system-directory">System Directory</a>
                                </li>
                            <?php elseif ($role === 'donor'): ?>
                                <li class="menu-item">
                                    <a href="#listings">My Donations</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#needs-catalogue">Requests Catalogue</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#matching">Donation Process</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#chat">Messages</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#admin-chat">Admin Inquiries</a>
                                </li>
                            <?php elseif ($role === 'receiver'): ?>
                                <li class="menu-item">
                                    <a href="#requests">Material Requests</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#matching">Donation Process</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#available-items">Available Donations</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#chat">Messages</a>
                                </li>
                                <li class="menu-item">
                                    <a href="#admin-chat">Admin Inquiries</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <li class="menu-item">
                            <a href="#profile">My Profile</a>
                        </li>
                        <li class="menu-item">
                            <a href="#history"><?php echo ($role === 'donor') ? 'Completed Donation History' : 'History'; ?></a>
                        </li>
                        
                        <li class="menu-item">
                            <a href="#notifications">Notifications</a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <!-- User profile footer info inside Sidebar -->
            <div class="user-profile-menu">
                <div class="profile-avatar" style="background-image: url('https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80');"></div>
                <div class="profile-info">
                    <div class="profile-name" title="<?php echo htmlspecialchars($name); ?>">
                        <?php echo htmlspecialchars($name); ?>
                    </div>
                    <div class="profile-role">
                        <?php echo htmlspecialchars($role); ?>
                        <?php if ($status === 'verified'): ?>
                            <span style="color: var(--color-success); font-size: 0.75rem; font-weight:700;">Verified</span>
                        <?php else: ?>
                            <span style="color: var(--color-warning); font-size: 0.75rem; font-weight:700;">Pending</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- MAIN DASHBOARD CONTENT AREA -->
        <main class="main-content">
            
            <!-- Header Panel -->
            <header class="header-panel">
                <div class="welcome-section">
                    <h1 class="gradient-text">Hello, <?php echo htmlspecialchars(explode(' ', $name)[0]); ?></h1>
                    <p>Welcome to your GiveGo dashboard. Manage records and activities below.</p>
                </div>
                
                <div class="actions-section" style="display:flex; align-items:center; gap:12px;">
                    <div class="notification-bell glass-panel" style="padding: 8px 16px; border-radius: var(--radius-sm); cursor:pointer;" id="btnNotificationsToggle">
                        <span style="font-size: 0.85rem; font-weight:700; color: var(--color-primary);">Alerts</span>
                        <span class="notification-dot" id="notiDot" style="display: none;"></span>
                    </div>
                    <button type="button" class="btn-header-logout" onclick="window.handleSignOut()" style="background:#FFFFFF; border:1px solid #FECACA; color:#DC2626; padding:8px 18px; border-radius:var(--radius-sm); font-size:0.85rem; font-weight:800; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; box-shadow:0 1px 4px rgba(0,0,0,0.04); transition:all 0.15s ease;" onmouseover="this.style.background='#DC2626'; this.style.color='#FFF';" onmouseout="this.style.background='#FFFFFF'; this.style.color='#DC2626';">
                        <span>Log Out</span>
                    </button>
                </div>
            </header>
            
            <!-- Dynamic Role-Based Views -->
            <div id="dashboardViewContainer">
                <?php if ($status === 'verified' || $role === 'admin'): ?>
                    <?php
                    if ($role === 'admin') {
                        include 'admin.php';
                    } elseif ($role === 'donor') {
                        include 'donor.php';
                    } elseif ($role === 'receiver') {
                        include 'receiver.php';
                    } else {
                        echo "<p>Invalid account configuration.</p>";
                    }
                    include 'available_items.php';
                    include 'history.php';
                    ?>
                    
                    <!-- Notifications Panel (Universal) -->
                    <?php if ($role !== 'admin'): ?>
                    <div class="dashboard-view-panel" id="notifications-panel" style="display:none;">
                        <h3 class="section-title">System Alerts &amp; Notifications</h3>
                        <div id="notificationsContainer"></div>
                    </div>
                    <?php endif; ?>

                    <!-- User Profile & Address Management Panel (Universal) -->
                    <div class="dashboard-view-panel" id="profile-panel" style="display:none;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
                            <div>
                                <h3 class="section-title" style="margin:0;">Account Profile &amp; Operating Address</h3>
                                <p style="color:var(--color-text-muted); font-size:0.88rem; margin-top:4px;">Manage your official organization profile, contact phone, operating address, and bank disbursement details.</p>
                            </div>
                            <button type="button" class="btn btn-primary" style="padding:10px 20px; font-weight:800; font-size:0.9rem;" onclick="openEditProfileModal()">Edit Profile &amp; Address</button>
                        </div>

                        <!-- Profile Overview Cards Grid -->
                        <div class="grid-cols-2" style="gap:20px; margin-bottom:24px;">
                            <!-- Card 1: Basic Identity & Account Details -->
                            <div class="glass-panel" style="padding:24px; background:#FFFFFF; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.04);">
                                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:12px; margin-bottom:16px;">
                                    <h4 style="color:var(--color-teal-primary); font-weight:800; margin:0; font-size:1.05rem;">Account Information</h4>
                                    <span id="prfStatusBadge" class="badge badge-success">Verified</span>
                                </div>
                                <div style="display:flex; flex-direction:column; gap:12px; font-size:0.9rem;">
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Full Name / Organization</span><strong id="prfDisplayName" style="color:var(--color-teal-primary); font-size:1.1rem;">-</strong></div>
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Email Address</span><span id="prfDisplayEmail">-</span></div>
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Account Role &amp; Category</span><span id="prfDisplayRole">-</span></div>
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Official Registration Number</span><span id="prfDisplayRegNum">-</span></div>
                                </div>
                            </div>

                            <!-- Card 2: Contact & Operating Address -->
                            <div class="glass-panel" style="padding:24px; background:#FFFFFF; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.04);">
                                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:12px; margin-bottom:16px;">
                                    <h4 style="color:var(--color-teal-primary); font-weight:800; margin:0; font-size:1.05rem;">Location &amp; Logistics Address</h4>
                                    <button type="button" class="btn btn-secondary" style="padding:4px 12px; font-size:0.8rem; font-weight:700;" onclick="openEditProfileModal()">Edit Address</button>
                                </div>
                                <div style="display:flex; flex-direction:column; gap:12px; font-size:0.9rem;">
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Contact Phone Number</span><strong id="prfDisplayPhone" style="color:#2D3748;">-</strong></div>
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">District / Province</span><span id="prfDisplayDistrict" style="font-weight:700; color:var(--color-teal-primary);">-</span></div>
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Street Address</span><span id="prfDisplayAddress">-</span></div>
                                    <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">City / Town</span><span id="prfDisplayCity">-</span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Receiver Bank & Disbursement Details Card (if Receiver) -->
                        <div id="prfReceiverBankCard" class="glass-panel" style="display:none; padding:24px; background:#FFFFFF; border-radius:12px; margin-bottom:24px; box-shadow:0 4px 15px rgba(0,0,0,0.04);">
                            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:12px; margin-bottom:16px;">
                                <h4 style="color:var(--color-teal-primary); font-weight:800; margin:0; font-size:1.05rem;">Official Bank Disbursement Details</h4>
                                <span style="font-size:0.8rem; color:var(--color-teal-muted); font-weight:700;">For Monetary Donation Transfers</span>
                            </div>
                            <div class="grid-cols-3" style="gap:16px; font-size:0.9rem;">
                                <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Bank Name</span><strong id="prfDisplayBankName">-</strong></div>
                                <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Account Name</span><strong id="prfDisplayAccountName">-</strong></div>
                                <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Account Number</span><strong id="prfDisplayAccountNumber" style="letter-spacing:1px;">-</strong></div>
                                <div><span style="color:var(--color-text-muted); font-weight:600; display:block; font-size:0.78rem; text-transform:uppercase;">Bank Branch</span><strong id="prfDisplayBankBranch">-</strong></div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Pending Review Layout -->
                    <div class="glass-panel" style="padding: 40px; text-align: center; max-width: 600px; margin: 40px auto; border-left: 4px solid var(--color-warning); background:#FFFFFF;">
                        <h2 style="font-size: 1.8rem; margin-bottom: 12px; color: var(--color-primary);">Verification Pending</h2>
                        <p style="color: var(--color-text-muted); font-size: 1.05rem; line-height: 1.6; margin-bottom: 24px;">
                            Thank you for registering with <strong>GiveGo</strong>.<br>
                            Your credentials and uploaded verification documents are currently under review by our administration team. 
                        </p>
                        <p style="font-size: 0.9rem; color: var(--color-text-muted);">
                            You will receive dashboard access automatically once your verification is approved.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            
        </main>
        
    </div>

    <!-- Modals -->
    <div class="modal" id="modalMonetaryDonation">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:500px;">
            <h3 id="mdlMonTitle" style="color:var(--color-primary); margin-bottom:10px;">Monetary Transfer</h3>
            <div id="mdlBankDetailsContent" style="background:#FBF5DD; padding:12px; border-radius:4px; margin-bottom:15px; font-size:0.85rem;"></div>
            <form id="formSubmitMonetaryDonation">
                <input type="hidden" id="mdlMonRequestId">
                <div class="form-group">
                    <label class="form-label">Transfer Amount (LKR)</label>
                    <input class="form-control" type="number" id="mdlMonAmount" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Transfer Date</label>
                    <input class="form-control" type="date" id="mdlMonDate" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Reference Number</label>
                    <input class="form-control" type="text" id="mdlMonRef" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Transaction Receipt (PNG / JPG / PDF) <span style="color:#E53E3E;">*</span></label>
                    <input class="form-control" type="file" id="monReceiptUploadInput" accept="image/*,.pdf" style="margin-bottom:6px;">
                    <div id="mdlMonReceiptPreviewBox" style="display:none; text-align:center; margin-top:8px; margin-bottom:8px;">
                        <img id="mdlMonReceiptPreviewImg" style="max-height:140px; max-width:100%; border-radius:6px; border:2px solid var(--color-teal-primary); object-fit:contain;" />
                    </div>
                    <small style="color:var(--color-text-muted); display:block;">Or paste direct image/document URL:</small>
                    <input class="form-control" type="text" id="mdlMonReceiptUrl" placeholder="https://... or choose file above" style="margin-top:4px;" required>
                </div>
                <button class="btn btn-primary" type="submit">Confirm Payment</button>
            </form>
        </div>
    </div>

    <!-- Modal: Donor Offering to Receiver Need -->
    <div class="modal" id="modalOfferDonation">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:520px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlOfferTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem;">Offer Donation</h3>
                <button type="button" class="btn btn-secondary" style="padding:2px 8px; font-size:0.75rem;" onclick="document.getElementById('modalOfferDonation').classList.remove('active')">✕</button>
            </div>
            <form id="formSubmitOfferDonation">
                <input type="hidden" id="mdlOfferRequestId">
                <div class="form-group">
                    <label class="form-label">Offered Quantity / Units</label>
                    <input class="form-control" type="number" id="mdlOfferQty" min="1" value="1" required style="font-weight:700;">
                    <div id="lblOfferMaxNotice" style="font-size:0.75rem; color:var(--color-teal-primary); font-weight:700; margin-top:4px;"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Item Condition / Notes (Optional)</label>
                    <textarea class="form-control" id="mdlOfferNotes" rows="2" placeholder="e.g. Brand new items in original sealed packaging"></textarea>
                </div>
                <div style="background:#F5EFE0; padding:12px; border-radius:6px; font-size:0.8rem; color:var(--color-text-dark); margin-bottom:16px; line-height:1.4;">
                    <strong>Workflow Note:</strong> Once the receiver accepts your donation offer, you will be notified to select your Delivery Method (Self Delivery with Date &amp; Time selection OR Receiver Pick Up).
                </div>
                <button class="btn btn-primary" type="submit" style="width:100%; font-weight:800; padding:12px;">Send Donation Offer to Receiver</button>
            </form>
        </div>
    </div>

    <!-- Modal: Receiver Requesting Available Item -->
    <div class="modal" id="modalRequestAvailableItem" style="z-index:999999;">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:520px; width:90%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlReqItemTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem; margin:0;">Request Material Item</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 10px; font-size:0.85rem; font-weight:800; cursor:pointer;" onclick="closeRequestAvailableItemModal()">✕</button>
            </div>
            <form id="formSubmitItemRequest" onsubmit="event.preventDefault(); submitReceiverItemRequestDirectly();">
                <input type="hidden" id="mdlReqDonationId">
                <div class="form-group" style="margin-bottom:14px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Requested Quantity / Units</label>
                    <input class="form-control" type="number" id="mdlReqItemQty" min="1" value="1" required style="font-weight:700; width:100%;">
                    <div id="lblReqItemMaxNotice" style="font-size:0.75rem; color:var(--color-teal-primary); font-weight:700; margin-top:4px;"></div>
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Delivery Method</label>
                    <input class="form-control" type="text" value="Self Pick Up (Receiver Pick Up)" readonly style="font-weight:800; background:#F5EFE0; color:var(--color-teal-primary); width:100%;">
                </div>
                <div style="background:#F5EFE0; padding:12px; border-radius:6px; font-size:0.8rem; color:var(--color-text-dark); margin-bottom:16px; line-height:1.4;">
                    As a Receiver requesting this available item, an automated notification will be sent to the donor to accept your request.
                </div>
                <div style="display:flex; gap:10px; justify-content:flex-end; align-items:center;">
                    <button type="button" class="btn btn-secondary" style="padding:10px 18px; font-size:0.85rem; font-weight:800; cursor:pointer;" onclick="closeRequestAvailableItemModal()">Cancel</button>
                    <button class="btn btn-primary" type="button" onclick="submitReceiverItemRequestDirectly()" style="font-weight:800; padding:10px 22px; font-size:0.88rem; background:#0C2D2A; color:#FFFFFF; border:none; border-radius:6px; cursor:pointer; box-shadow:0 3px 10px rgba(12,45,42,0.3);">Send Item Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Receiver Scheduling Pick Up for Pending Offer -->
    <div class="modal" id="modalScheduleReceiverPickup">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:500px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem;">Schedule Pick Up Date &amp; Time</h3>
                <button type="button" class="btn btn-secondary" style="padding:2px 8px; font-size:0.75rem;" onclick="document.getElementById('modalScheduleReceiverPickup').classList.remove('active')">✕</button>
            </div>
            <form id="formSubmitReceiverPickupSchedule">
                <input type="hidden" id="mdlScheduleMatchId">
                <div class="form-group">
                    <label class="form-label">Select Pick Up Date &amp; Time</label>
                    <input class="form-control" type="datetime-local" id="mdlScheduleDateTime" required style="font-weight:700;">
                </div>
                <button class="btn btn-primary" type="submit" style="width:100%; font-weight:800; padding:12px;">Schedule &amp; Notify Donor</button>
            </form>
        </div>
    </div>

    <!-- Modal: Donor Selects Delivery Method after Receiver Acceptance -->
    <div class="modal" id="modalDonorSelectDelivery">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:520px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem;">Select Delivery Method</h3>
                <button type="button" class="btn btn-secondary" style="padding:2px 8px; font-size:0.75rem;" onclick="document.getElementById('modalDonorSelectDelivery').classList.remove('active')">✕</button>
            </div>
            <form id="formSubmitDonorDeliverySelection">
                <input type="hidden" id="mdlDonorDelivMatchId">
                <div class="form-group">
                    <label class="form-label">Delivery Method</label>
                    <select class="form-control form-select" id="mdlDonorDelivMethod" required style="font-weight:700;">
                        <option value="self_delivery">Self Delivery (Donor Delivers to Receiver)</option>
                        <option value="receiver_pickup">Receiver Pick Up (Receiver Schedules Pick Up)</option>
                    </select>
                </div>
                <div class="form-group" id="grpDonorSelDateTime">
                    <label class="form-label">Scheduled Delivery Date &amp; Time</label>
                    <input class="form-control" type="datetime-local" id="mdlDonorSelDateTime" style="font-weight:700;">
                </div>
                <div id="grpReceiverPickupInfoNotice" style="display:none; background:#F5EFE0; padding:12px; border-radius:6px; font-size:0.8rem; color:var(--color-text-dark); margin-bottom:16px;">
                    You selected Receiver Pick Up. The receiver will be notified to choose their preferred pick-up date &amp; time.
                </div>
                <button class="btn btn-primary" type="submit" style="width:100%; font-weight:800; padding:12px;">Submit &amp; Notify Receiver</button>
            </form>
        </div>
    </div>

    <!-- Modal: Negotiate / Propose New Schedule -->
    <div class="modal" id="modalNegotiateSchedule">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:500px; width:90%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem;">Negotiate Date &amp; Time</h3>
                <button type="button" class="btn btn-secondary" style="padding:2px 8px; font-size:0.75rem;" onclick="document.getElementById('modalNegotiateSchedule').classList.remove('active')">✕</button>
            </div>
            <form id="formSubmitNegotiateSchedule">
                <input type="hidden" id="mdlNegMatchId">
                <div class="form-group">
                    <label class="form-label">Propose New Date &amp; Time</label>
                    <input class="form-control" type="datetime-local" id="mdlNegDateTime" required style="font-weight:700;">
                </div>
                <div class="form-group">
                    <label class="form-label">Message / Reason (Optional)</label>
                    <textarea class="form-control" id="mdlNegReason" rows="2" placeholder="e.g. Can we shift this by 2 hours?"></textarea>
                </div>
                <button class="btn btn-primary" type="submit" style="width:100%; font-weight:800; padding:12px;">Send Proposed Schedule</button>
            </form>
        </div>
    </div>

    <!-- Modal: Receiver Upload Handover Evidence Image -->
    <div class="modal" id="modalHandoverEvidence" style="z-index:999999;">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:540px; width:92%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlEvidenceTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem; margin:0;">Upload Handover Evidence Photo</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 10px; font-size:0.85rem; font-weight:800; cursor:pointer;" onclick="closeHandoverEvidenceModal()">✕</button>
            </div>
            <form id="formSubmitHandoverEvidence" onsubmit="event.preventDefault(); submitHandoverEvidenceDirectly();">
                <input type="hidden" id="mdlEvidenceMatchId">
                <div class="form-group" style="margin-bottom:14px;">
                    <label class="form-label" style="font-size:0.85rem; font-weight:700;">Upload Photo of Received Items <span style="color:#E53E3E;">* (Required)</span></label>
                    <input class="form-control" type="file" id="mdlEvidenceFileInput" accept="image/*" style="margin-bottom:6px;">
                    <div id="mdlEvidencePreviewBox" style="display:none; text-align:center; margin-top:8px; margin-bottom:8px;">
                        <img id="mdlEvidencePreviewImg" style="max-height:160px; max-width:100%; border-radius:8px; border:2px solid var(--color-teal-primary); object-fit:contain;" />
                    </div>
                    <small style="color:var(--color-text-muted); display:block; margin-top:4px;">Or paste direct image URL below <span style="color:#E53E3E;">*</span>:</small>
                    <input class="form-control" type="url" id="mdlEvidenceUrl" placeholder="https://example.com/handover-photo.jpg" style="margin-top:4px;">
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label class="form-label" style="font-size:0.85rem; font-weight:700;">Handover Notes / Feedback (Optional)</label>
                    <textarea class="form-control" id="mdlEvidenceNotes" rows="2" placeholder="e.g. Received items in excellent condition."></textarea>
                </div>
                <div style="background:#FFF5F5; border:1px solid #FEB2B2; padding:10px 14px; border-radius:6px; font-size:0.8rem; color:#C53030; font-weight:700; margin-bottom:16px; line-height:1.4;">
                    Mandatory Evidence: You must attach a clear photo of the received items or provide a valid photo link before your receipt can be confirmed.
                </div>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn btn-secondary" style="padding:8px 16px; font-size:0.85rem; font-weight:700; cursor:pointer;" onclick="closeHandoverEvidenceModal()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitHandoverEvidenceDirectly()" style="padding:8px 20px; font-size:0.88rem; font-weight:800; background:#0C2D2A; color:#FFF; border:none; border-radius:6px; cursor:pointer; box-shadow:0 3px 10px rgba(12,45,42,0.3);">Upload Evidence &amp; Confirm Receipt</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Universal Evidence Photo Lightbox Viewer -->
    <div class="modal" id="modalEvidenceImageViewer" style="z-index:9999999; background:rgba(0,0,0,0.75);">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:680px; width:95%; border-radius:12px; box-shadow:0 12px 35px rgba(0,0,0,0.4); max-height:90vh; display:flex; flex-direction:column;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlImageViewerTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem; margin:0;">Handover Evidence Photo</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 12px; font-size:0.9rem; font-weight:800; cursor:pointer;" onclick="closeEvidenceImageViewer()">Close</button>
            </div>
            <div style="flex:1; overflow-y:auto; text-align:center; padding:10px 0;">
                <img id="mdlImageViewerImg" src="" alt="Handover Evidence" style="max-width:100%; max-height:55vh; border-radius:8px; border:2px solid var(--color-teal-primary); object-fit:contain; box-shadow:0 4px 15px rgba(0,0,0,0.15);" />
                <div id="mdlImageViewerNotes" style="margin-top:12px; font-size:0.85rem; color:#2D3748; background:#F7FAFC; padding:10px; border-radius:6px; text-align:left; border-left:4px solid var(--color-teal-primary);"></div>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:10px; border-top:1px solid var(--color-border);">
                <a id="mdlImageViewerDownload" href="#" download="handover-evidence.jpg" class="btn btn-primary" style="padding:6px 14px; font-size:0.82rem; font-weight:800; background:#0C2D2A; color:#FFF; text-decoration:none; border-radius:6px;">⬇ Download Full Resolution</a>
                <button type="button" class="btn btn-secondary" style="padding:6px 14px; font-size:0.82rem; font-weight:700;" onclick="closeEvidenceImageViewer()">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal: Admin Real-Time Chat Log Inspector -->
    <div class="modal" id="modalAdminInspectChat">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:620px; width:92%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlAdminInspectTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem;">Admin Chat Inspector</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 10px; font-size:0.85rem; font-weight:800; cursor:pointer;" onclick="closeAdminInspectChat()">✕</button>
            </div>
            <div id="adminChatMessagesContainer" style="height:320px; overflow-y:auto; border:1px solid var(--color-border); padding:12px; border-radius:6px; background:#FBF5DD; margin-bottom:12px;"></div>
            <div style="font-size:0.78rem; color:var(--color-text-muted); text-align:center;">
                Read-only view for system compliance &amp; dispute resolution monitoring.
            </div>
        </div>
    </div>

    <!-- Modal: Donor Volunteer Shift Sign Up -->
    <div class="modal" id="modalVolunteerSignup" style="z-index:99999999;">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:560px; width:92%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlVolunteerTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.15rem; margin:0;">Sign Up for Volunteer Shift</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 10px; font-size:0.85rem; font-weight:800; cursor:pointer;" onclick="closeVolunteerModal()">✕</button>
            </div>
            <form id="formSubmitVolunteerSignup" onsubmit="event.preventDefault(); submitVolunteerShiftDirectly();">
                <input type="hidden" id="mdlVolunteerRequestId">
                <div id="mdlVolunteerDetailsBox" style="background:#F0FDF4; border:1px solid #86EFAC; border-radius:8px; padding:12px; margin-bottom:14px; font-size:0.85rem; color:#14532D;">
                    <div id="mdlVolunteerOrgInfo" style="font-weight:700; margin-bottom:4px;"></div>
                    <div id="mdlVolunteerShiftInfo" style="margin-bottom:4px;"></div>
                    <div id="mdlVolunteerEquipmentInfo"></div>
                </div>
                <div class="form-group" style="margin-bottom:12px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Your Full Name <span style="color:#E53E3E;">*</span></label>
                    <input type="text" class="form-control" id="mdlVolunteerName" required placeholder="e.g. John Doe">
                </div>
                <div class="form-group" style="margin-bottom:12px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Contact Phone Number <span style="color:#E53E3E;">*</span></label>
                    <input type="tel" class="form-control" id="mdlVolunteerPhone" required placeholder="e.g. +94 77 123 4567">
                </div>
                <div class="form-group" style="margin-bottom:12px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Number of Volunteers Joining <span style="color:#E53E3E;">*</span></label>
                    <input type="number" class="form-control" id="mdlVolunteerCount" min="1" max="50" value="1" required>
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Skills / Notes (Optional)</label>
                    <textarea class="form-control" id="mdlVolunteerNotes" rows="2" placeholder="e.g. First Aid certified, available entire morning."></textarea>
                </div>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn btn-secondary" style="padding:8px 16px; font-weight:700; cursor:pointer;" onclick="closeVolunteerModal()">Cancel</button>
                    <button type="submit" id="btnSubmitVolunteerReg" class="btn btn-primary" style="padding:8px 20px; font-weight:800; background:#0C2D2A; color:#FFF; border:none; border-radius:6px; cursor:pointer; box-shadow:0 3px 10px rgba(12,45,42,0.3);">Confirm Shift Registration</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Real-Time Live Location Tracker Map -->
    <div class="modal" id="modalLiveLocationTracker">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:680px; width:95%;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlTrackerTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem;">Live Location Tracker</h3>
                <button type="button" class="btn btn-secondary" style="padding:2px 8px; font-size:0.75rem;" onclick="stopLiveLocationTrackerModal()">✕</button>
            </div>
            <div id="liveTrackerMapContainer" style="height:360px; width:100%; border-radius:8px; border:1px solid var(--color-border); margin-bottom:12px; background:#F5EFE0;"></div>
            <div id="trackerStatusDetails" style="font-size:0.85rem; font-weight:700; color:var(--color-teal-primary); text-align:center;">
                Connecting to real-time GPS location stream...
            </div>
        </div>
    </div>

    <!-- Modal: Edit Profile & Address -->
    <div class="modal" id="modalEditProfile" style="z-index:99999999;">
        <div class="modal-content glass-panel" style="padding:28px; background:#FFFFFF; max-width:620px; width:92%; border-radius:12px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 style="color:var(--color-teal-primary); font-weight:800; font-size:1.15rem; margin:0;">Edit Profile &amp; Address Details</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 10px; font-size:0.85rem; font-weight:800; cursor:pointer;" onclick="closeEditProfileModal()">Close</button>
            </div>
            <form id="formSubmitEditProfile" onsubmit="event.preventDefault(); submitEditProfileDirectly();">
                <!-- Profile Photo Upload / Edit -->
                <div style="display:flex; align-items:center; gap:16px; margin-bottom:18px; padding-bottom:16px; border-bottom:1px solid var(--color-border);">
                    <div id="editPrfAvatarPreview" style="width:64px; height:64px; border-radius:50%; background:var(--color-teal-primary); color:#FFFFFF; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.2rem; background-size:cover; background-position:center; flex-shrink:0; border:2px solid var(--color-border); overflow:hidden;">U</div>
                    <div>
                        <input type="file" id="editPrfPhotoInput" accept="image/*" style="display:none;" onchange="handleEditProfilePhotoSelected(this)">
                        <button type="button" class="btn btn-secondary" style="font-size:0.8rem; font-weight:700; padding:6px 12px; cursor:pointer;" onclick="document.getElementById('editPrfPhotoInput').click()">Upload New Photo</button>
                        <small style="color:var(--color-text-muted); display:block; margin-top:4px; font-size:0.75rem;">JPG, PNG or WEBP (Max 5MB)</small>
                    </div>
                </div>
                <div class="grid-cols-2" style="gap:14px; margin-bottom:14px;">
                    <div class="form-group">
                        <label class="form-label" style="font-weight:700; font-size:0.85rem;">Full Name / Organization Name</label>
                        <input type="text" class="form-control" id="editPrfName" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-weight:700; font-size:0.85rem;">Contact Phone Number</label>
                        <input type="tel" class="form-control" id="editPrfPhone" required>
                    </div>
                </div>

                <div class="grid-cols-2" style="gap:14px; margin-bottom:14px;">
                    <div class="form-group">
                        <label class="form-label" style="font-weight:700; font-size:0.85rem;">District / Operating Region</label>
                        <select class="form-control form-select" id="editPrfDistrict" required>
                            <option value="Colombo">Colombo</option>
                            <option value="Gampaha">Gampaha</option>
                            <option value="Kalutara">Kalutara</option>
                            <option value="Kandy">Kandy</option>
                            <option value="Matale">Matale</option>
                            <option value="Nuwara Eliya">Nuwara Eliya</option>
                            <option value="Galle">Galle</option>
                            <option value="Matara">Matara</option>
                            <option value="Hambantota">Hambantota</option>
                            <option value="Jaffna">Jaffna</option>
                            <option value="Kilinochchi">Kilinochchi</option>
                            <option value="Mannar">Mannar</option>
                            <option value="Vavuniya">Vavuniya</option>
                            <option value="Mullaitivu">Mullaitivu</option>
                            <option value="Batticaloa">Batticaloa</option>
                            <option value="Ampara">Ampara</option>
                            <option value="Trincomalee">Trincomalee</option>
                            <option value="Kurunegala">Kurunegala</option>
                            <option value="Puttalam">Puttalam</option>
                            <option value="Anuradhapura">Anuradhapura</option>
                            <option value="Polonnaruwa">Polonnaruwa</option>
                            <option value="Badulla">Badulla</option>
                            <option value="Moneragala">Moneragala</option>
                            <option value="Ratnapura">Ratnapura</option>
                            <option value="Kegalle">Kegalle</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="font-weight:700; font-size:0.85rem;">City / Town</label>
                        <input type="text" class="form-control" id="editPrfCity" placeholder="e.g. Peradeniya / Colombo 03">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:14px;">
                    <label class="form-label" style="font-weight:700; font-size:0.85rem;">Full Street Address / Premise Location</label>
                    <input type="text" class="form-control" id="editPrfAddress" placeholder="e.g. No 45, Kandy Road" required>
                </div>

                <!-- Receiver-Specific Bank Details in Edit Modal -->
                <div id="secEditReceiverBank" style="display:none; background:#F5EFE0; padding:14px; border-radius:8px; margin-bottom:14px;">
                    <div style="font-weight:800; color:var(--color-teal-primary); font-size:0.88rem; margin-bottom:10px;">Official Bank Account Details (for Grant Receipts)</div>
                    <div class="grid-cols-2" style="gap:10px; margin-bottom:10px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size:0.8rem; font-weight:700;">Bank Name</label>
                            <input type="text" class="form-control" id="editPrfBankName" placeholder="e.g. Bank of Ceylon">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:0.8rem; font-weight:700;">Account Name</label>
                            <input type="text" class="form-control" id="editPrfAccountName" placeholder="e.g. Children Trust Fund">
                        </div>
                    </div>
                    <div class="grid-cols-2" style="gap:10px;">
                        <div class="form-group">
                            <label class="form-label" style="font-size:0.8rem; font-weight:700;">Account Number</label>
                            <input type="text" class="form-control" id="editPrfAccountNumber" placeholder="e.g. 1234567890">
                        </div>
                        <div class="form-group">
                            <label class="form-label" style="font-size:0.8rem; font-weight:700;">Bank Branch</label>
                            <input type="text" class="form-control" id="editPrfBankBranch" placeholder="e.g. Colombo Main">
                        </div>
                    </div>
                </div>

                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn btn-secondary" style="padding:8px 16px; font-weight:700; cursor:pointer;" onclick="closeEditProfileModal()">Cancel</button>
                    <button type="submit" id="btnSubmitProfileSave" class="btn btn-primary" style="padding:8px 24px; font-weight:800; background:#0C2D2A; color:#FFF; border:none; border-radius:6px; cursor:pointer;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Universal Transaction Receipt Lightbox Viewer -->
    <div class="modal" id="modalReceiptViewer" style="z-index:99999999; background:rgba(0,0,0,0.75);">
        <div class="modal-content glass-panel" style="padding:24px; background:#FFFFFF; max-width:680px; width:95%; border-radius:12px; box-shadow:0 12px 35px rgba(0,0,0,0.4); max-height:90vh; display:flex; flex-direction:column;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
                <h3 id="mdlReceiptViewerTitle" style="color:var(--color-teal-primary); font-weight:800; font-size:1.1rem; margin:0;">Transaction Receipt</h3>
                <button type="button" class="btn btn-secondary" style="padding:4px 12px; font-size:0.9rem; font-weight:800; cursor:pointer;" onclick="closeReceiptViewer()">Close</button>
            </div>
            <div id="mdlReceiptDetailsBox" style="background:#F5EFE0; padding:10px 14px; border-radius:6px; margin-bottom:12px; font-size:0.85rem; color:var(--color-text-dark); display:none;"></div>
            <div style="flex:1; overflow-y:auto; text-align:center; padding:10px 0;" id="mdlReceiptViewerBody">
                <img id="mdlReceiptViewerImg" src="" alt="Transaction Receipt" style="max-width:100%; max-height:55vh; border-radius:8px; border:2px solid var(--color-teal-primary); object-fit:contain; box-shadow:0 4px 15px rgba(0,0,0,0.15);" />
                <iframe id="mdlReceiptViewerPdf" src="" style="width:100%; height:50vh; border:1px solid var(--color-border); border-radius:8px; display:none;"></iframe>
                <div id="mdlReceiptFallbackNotice" style="display:none; padding:30px 20px; text-align:center; background:#FFF5F5; border:1px solid #FEB2B2; border-radius:8px; color:#C53030; font-weight:700;">
                    Receipt is not available for this transaction.
                </div>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:10px; border-top:1px solid var(--color-border);">
                <a id="mdlReceiptViewerFullBtn" href="#" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="padding:6px 14px; font-size:0.82rem; font-weight:800; background:#0C2D2A; color:#FFF; text-decoration:none; border-radius:6px;">Open Full Size</a>
                <button type="button" class="btn btn-secondary" style="padding:6px 14px; font-size:0.82rem; font-weight:700;" onclick="closeReceiptViewer()">Close</button>
            </div>
        </div>
    </div>

    <!-- Modal: Account Suspended Alert -->
    <div class="modal" id="modalAccountSuspendedNotice" style="z-index:999999999; background:rgba(0,0,0,0.8);">
        <div class="modal-content glass-panel" style="padding:28px; background:#FFFFFF; max-width:540px; width:92%; border-radius:12px; box-shadow:0 15px 40px rgba(0,0,0,0.5); text-align:center;">
            <div style="width:64px; height:64px; background:#FEE2E2; color:#DC2626; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:2rem; margin:0 auto 16px auto;">
                🔒
            </div>
            <h3 style="color:#991B1B; font-weight:900; font-size:1.3rem; margin:0 0 8px 0;">Account Suspended</h3>
            <p style="color:#4B5563; font-size:0.9rem; line-height:1.5; margin:0 0 20px 0;">
                An Administrator has suspended your GiveGo account. While your account is suspended, all donation submissions, request creations, matching offers, volunteer registrations, and chat messages are disabled.
            </p>
            <div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:12px; margin-bottom:20px; text-align:left; font-size:0.85rem; color:#991B1B;">
                <div style="font-weight:700; margin-bottom:4px;">Need help or want to appeal?</div>
                <div>Please reach out to GiveGo Support at <a href="mailto:support@givego.lk" style="color:#991B1B; font-weight:700; text-decoration:underline;">support@givego.lk</a> or call <strong>+94 11 234 5678</strong>.</div>
            </div>
            <div style="display:flex; gap:10px; justify-content:center;">
                <button type="button" class="btn btn-secondary" style="padding:10px 20px; font-weight:800; font-size:0.88rem;" onclick="document.getElementById('modalAccountSuspendedNotice').classList.remove('active')">Acknowledge</button>
                <button type="button" class="btn btn-danger" style="padding:10px 20px; font-weight:800; font-size:0.88rem; background:#DC2626; color:#FFF; border:none;" onclick="document.getElementById('btnLogout')?.click()">Log Out</button>
            </div>
        </div>
    </div>

    <!-- Google Maps JavaScript API Assets -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy8_Ic4K9OEPV6P6aKdm0w95A3qvLFudE&libraries=places,geometry&callback=onGoogleMapsLoaded" async defer></script>

    <!-- Core Javascript Files -->
    <script src="js/firebase-config.js"></script>
    <script src="js/auth.js?v=150.0"></script>
    <script src="js/app.js?v=157.0"></script>
    
    <script>
        const btnLogoutEl = document.getElementById("btnLogout");
        if (btnLogoutEl) {
            btnLogoutEl.addEventListener("click", () => {
                if (window.handleSignOut) {
                    window.handleSignOut();
                } else if (window.authEngine) {
                    window.authEngine.logout();
                }
            });
        }
    </script>
</body>
</html>
