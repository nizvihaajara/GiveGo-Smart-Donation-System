<!-- Admin Dashboard Panel -->
<!-- 1. OVERVIEW SECTION -->
<div id="overview-panel" class="dashboard-view-panel">
    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Pending Approvals</h3>
                <div class="stat-number" id="statPendingApprovalsCount">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Published Needs</h3>
                <div class="stat-number" id="statTotalRequests">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Match Allocation Rate</h3>
                <div class="stat-number" id="statMatchRate">0%</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Registered Users</h3>
                <div class="stat-number" id="statTotalUsers">0</div>
            </div>
        </div>
    </div>

    <!-- Quick action layout -->
    <div class="dashboard-grid">
        <!-- Reports and Statistics Widget -->
        <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
            <div class="card-header">
                <h3 class="card-title">System Activities &amp; Compliance Reports</h3>
                <button type="button" onclick="window.downloadSystemReport && window.downloadSystemReport()" class="btn btn-primary" style="padding: 7px 16px; font-size: 0.82rem; border-radius: 6px; display: inline-flex; align-items: center; gap: 6px; font-weight: 800; cursor: pointer; background: #0C2D2A; color: #FFFFFF; border: none; box-shadow: 0 2px 6px rgba(12,45,42,0.3);">
                    <span>📊 Download CSV Report</span>
                </button>
            </div>
            <p style="color:var(--color-text-muted); font-size:0.9rem; margin-bottom: 20px;">
                Retrieve summary logs of donations, active matching records, receiver bank evidence, categories, and users.
            </p>
            <div id="reportsCategoryList" style="margin-top: 10px;">
                <!-- Filled dynamically by app.js -->
            </div>
        </div>

        <!-- Publish System Announcement Card -->
        <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
            <div class="card-header">
                <h3 class="card-title">Publish System Announcement</h3>
            </div>
            <form id="formPublishAnnouncement">
                <div class="form-group">
                    <label class="form-label">Announcement Title</label>
                    <input type="text" class="form-control" id="annTitle" placeholder="e.g. System Maintenance Schedule" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Announcement Content</label>
                    <textarea class="form-control" id="annContent" rows="4" placeholder="Enter system announcement context..." required></textarea>
                </div>
                <button class="btn btn-primary" type="submit" style="width: 100%;">
                    Publish Announcement
                </button>
            </form>
        </div>
    </div>
</div>

<!-- 2. USER ACCOUNTS SECTION -->
<div id="users-panel" class="dashboard-view-panel" style="display: none;">
    <div class="glass-panel" style="padding: 30px; margin-bottom: 24px; background: #FFFFFF;">
        <div class="card-header">
            <h3 class="card-title">System User Accounts Directory</h3>
        </div>
        <div style="margin-bottom: 20px;">
            <input type="text" id="searchAdminUsers" class="form-control" placeholder="Search user accounts by name, email, district, or role..." style="max-width: 350px;">
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name / Org</th>
                        <th>Email</th>
                        <th>Role &amp; Type</th>
                        <th>District</th>
                        <th>Verification Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="adminUsersBody">
                    <!-- Filled dynamically by app.js -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 3. APPROVALS/VERIFICATION CENTER SECTION -->
<div id="approvals-panel" class="dashboard-view-panel" style="display: none;">
    <!-- Pending User Accounts & Bank Verification -->
    <div class="glass-panel" style="padding: 30px; margin-bottom: 30px; background: #FFFFFF;">
        <div class="card-header" style="border-bottom: 1.5px solid var(--color-border); margin-bottom: 20px; padding-bottom: 15px;">
            <h3 class="card-title">Pending Account &amp; Bank Proof Verifications</h3>
        </div>
        <div class="grid-cols-2" id="adminApprovalsGrid" style="gap: 20px; margin-top: 10px;">
            <!-- Filled dynamically by app.js -->
        </div>
    </div>

    <!-- Pending Requests Approvals (Pre-Publication Review) -->
    <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
        <div class="card-header" style="border-bottom: 1.5px solid var(--color-border); margin-bottom: 20px; padding-bottom: 15px;">
            <h3 class="card-title">Pending Request Approvals (Pre-Publication Review)</h3>
        </div>
        <div class="grid-cols-2" id="adminRequestApprovalsGrid" style="gap: 20px; margin-top: 10px;">
            <!-- Filled dynamically by app.js -->
        </div>
    </div>

    <!-- Handover Evidence Image Verification Queue -->
    <div class="glass-panel" style="padding: 30px; background: #FFFFFF; margin-top: 30px;">
        <div class="card-header" style="border-bottom: 1.5px solid var(--color-border); margin-bottom: 20px; padding-bottom: 15px;">
            <h3 class="card-title">Receiver Handover Evidence Image Verifications</h3>
        </div>
        <div class="grid-cols-2" id="adminEvidenceApprovalsGrid" style="gap: 20px; margin-top: 10px;">
            <!-- Filled dynamically by app.js -->
        </div>
    </div>
</div>

<!-- 4. ANNOUNCEMENTS ARCHIVE -->
<div id="announcements-panel" class="dashboard-view-panel" style="display: none;">
    <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
        <div class="card-header">
            <h3 class="card-title">System Announcements Archive</h3>
        </div>
        <div id="announcementsContainer" style="max-height: 500px; overflow-y: auto; margin-top: 10px;">
            <!-- Filled dynamically by app.js -->
        </div>
    </div>
</div>

<!-- 5. NOTIFICATIONS SECTION -->
<div id="notifications-panel" class="dashboard-view-panel" style="display: none;">
    <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
        <div class="card-header">
            <h3 class="card-title">My Alerts Log</h3>
        </div>
        <div id="notificationsListContainer" style="max-height: 500px; overflow-y: auto;">
            <!-- Filled dynamically by app.js -->
        </div>
    </div>
</div>

<!-- 6. SYSTEM DIRECTORY SECTION -->
<div id="system-directory-panel" class="dashboard-view-panel" style="display: none;">
    <div class="glass-panel" style="padding: 30px; margin-bottom: 24px; background: #FFFFFF;">
        <div class="card-header">
            <h3 class="card-title">Audit All System Listings &amp; Requests</h3>
            <span style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700;">ADMIN AUDIT</span>
        </div>
        <div class="grid-cols-2" style="gap: 16px; margin-bottom: 20px;">
            <div>
                <label class="form-label">Search Donations</label>
                <input type="text" id="searchAdminDonations" class="form-control" placeholder="Search all donations...">
            </div>
            <div>
                <label class="form-label">Search Requests</label>
                <input type="text" id="searchAdminRequests" class="form-control" placeholder="Search all requests...">
            </div>
        </div>
        <div class="grid-cols-2" style="gap: 20px; margin-top: 10px;">
            <div>
                <h4 style="margin-bottom: 12px; color: var(--color-primary);">Donations Directory</h4>
                <div id="adminDonationsGrid" style="display: flex; flex-direction: column; gap: 12px; max-height: 400px; overflow-y: auto;">
                    <!-- Filled dynamically by app.js -->
                </div>
            </div>
            <div>
                <h4 style="margin-bottom: 12px; color: var(--color-primary);">Material &amp; Fund Requests</h4>
                <div id="adminRequestsGrid" style="display: flex; flex-direction: column; gap: 12px; max-height: 400px; overflow-y: auto;">
                    <!-- Filled dynamically by app.js -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 7. INQUIRIES SECTION -->
<div class="dashboard-view-panel" id="inquiries-panel" style="display:none;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; flex-wrap:wrap; gap:12px;">
        <div>
            <h3 class="section-title" style="color:var(--color-teal-primary); font-weight:800; margin:0; font-size:1.3rem; letter-spacing:-0.02em;">
                Inquiries
            </h3>
            <p style="color:var(--color-text-muted); font-size:0.88rem; margin-top:4px;">
                Direct inquiries and assistance desk for registered Donors and Receivers.
            </p>
        </div>
        <div style="display:flex; gap:8px; align-items:center;">
            <span class="badge badge-info" id="adminInquiriesTotalBadge" style="padding:6px 12px; font-weight:700; font-size:0.8rem;">0 Inquiries</span>
            <button type="button" class="btn btn-secondary" style="padding:6px 12px; font-weight:700; font-size:0.8rem;" onclick="window.renderAdminInquiries && window.renderAdminInquiries()">Refresh Inquiries</button>
        </div>
    </div>

    <!-- Quick Metrics Row -->
    <div class="admin-kpi-grid" style="margin-bottom:20px;">
        <div class="admin-kpi-card info">
            <div class="admin-kpi-label">Total Inquiries</div>
            <div class="admin-kpi-val" id="statInquiriesTotal">0</div>
            <div class="admin-kpi-sub">All correspondence</div>
        </div>
        <div class="admin-kpi-card success">
            <div class="admin-kpi-label">Donor Inquiries</div>
            <div class="admin-kpi-val" id="statInquiriesDonors">0</div>
            <div class="admin-kpi-sub">From registered donors</div>
        </div>
        <div class="admin-kpi-card warning">
            <div class="admin-kpi-label">Receiver Inquiries</div>
            <div class="admin-kpi-val" id="statInquiriesReceivers">0</div>
            <div class="admin-kpi-sub">From verified receivers</div>
        </div>
        <div class="admin-kpi-card guest">
            <div class="admin-kpi-label">Guest Inquiries</div>
            <div class="admin-kpi-val" id="statInquiriesGuests">0</div>
            <div class="admin-kpi-sub">Unregistered visitors</div>
        </div>
        <div class="admin-kpi-card danger">
            <div class="admin-kpi-label">Pending Review</div>
            <div class="admin-kpi-val" id="statInquiriesUnresolved">0</div>
            <div class="admin-kpi-sub">Awaiting reply</div>
        </div>
    </div>

    <!-- Segmented Two-Panel Inquiries Desk -->
    <div class="inquiries-container-two-panel">
        <!-- Left Sidebar List -->
        <div class="inquiries-sidebar-pane">
            <div class="inquiries-sidebar-header">
                <!-- Segmented Filter Tabs -->
                <div class="inquiry-tabs-nav" id="adminInquiryTabsNav">
                    <button type="button" class="inquiry-tab-btn active" data-tab="all" onclick="window.switchInquiryTab('all')">All</button>
                    <button type="button" class="inquiry-tab-btn" data-tab="donor" onclick="window.switchInquiryTab('donor')">Donors</button>
                    <button type="button" class="inquiry-tab-btn" data-tab="receiver" onclick="window.switchInquiryTab('receiver')">Receivers</button>
                    <button type="button" class="inquiry-tab-btn" data-tab="guest" onclick="window.switchInquiryTab('guest')">Guests</button>
                    <button type="button" class="inquiry-tab-btn" data-tab="pending" onclick="window.switchInquiryTab('pending')">Unread</button>
                </div>
                <div>
                    <input type="text" class="form-control form-control-sm" id="searchAdminInquiries" placeholder="Search sender, email, topic..." style="font-size:0.82rem; padding:7px 12px; border-radius:6px;" oninput="window.renderAdminInquiries && window.renderAdminInquiries()">
                </div>
            </div>
            <div class="inquiries-list-scroll" id="adminInquiriesListContainer">
                <!-- Populated dynamically by app.js -->
            </div>
        </div>

        <!-- Right Active Conversation Pane -->
        <div class="inquiries-main-pane" id="adminInquiryMainPane">
            <!-- Active Header -->
            <div class="inquiries-active-header" id="adminInquiryActiveHeader" style="display:none;">
                <div class="inquiries-user-meta-box">
                    <div class="inquiry-avatar" id="inqActiveAvatar">U</div>
                    <div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <h4 style="margin:0; font-weight:800; font-size:1.05rem; color:#0F172A;" id="inqActiveUserName">User Name</h4>
                            <span class="inquiry-role-pill donor" id="inqActiveRoleBadge">DONOR</span>
                            <span class="badge badge-success" id="inqActiveStatusBadge" style="font-size:0.7rem;">OPEN</span>
                        </div>
                        <div style="font-size:0.8rem; color:#64748B; margin-top:2px;">
                            <span id="inqActiveUserEmail">user@givego.lk</span> &bull; <span id="inqActiveUserDistrict">Colombo</span> &bull; <span id="inqActiveUserPhone">+94 77 123 4567</span>
                        </div>
                    </div>
                </div>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button type="button" class="btn btn-secondary" id="btnToggleInquiryStatus" style="font-size:0.8rem; font-weight:700; padding:6px 14px;" onclick="window.toggleAdminInquiryStatus && window.toggleAdminInquiryStatus()">Mark as Resolved</button>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="inquiries-messages-container" id="adminInquiryMessagesContainer" style="display:none;">
                <!-- Chat bubbles rendered dynamically -->
            </div>

            <!-- Reply Bar -->
            <form class="inquiry-reply-bar" id="formAdminInquiryReply" style="display:none;" onsubmit="event.preventDefault(); window.submitAdminInquiryReply && window.submitAdminInquiryReply();">
                <input type="text" class="form-control" id="inputAdminInquiryReply" placeholder="Type response to user..." autocomplete="off" style="font-size:0.88rem; padding:10px 14px;" required>
                <button type="submit" class="btn btn-primary" style="padding:10px 20px; font-weight:800; font-size:0.88rem;">Send Reply</button>
            </form>

            <!-- Empty State Placeholder -->
            <div class="inquiry-empty-state" id="adminInquiryEmptyPlaceholder">
                <h4 style="margin:0 0 6px 0; color:var(--color-teal-primary); font-weight:800; font-size:1.15rem;">Select an Inquiry Thread</h4>
                <p style="font-size:0.88rem; color:var(--color-text-muted); max-width:380px; margin:0 auto; line-height:1.5;">Choose a donor or receiver inquiry from the left pane to review messages and provide official administrative support.</p>
            </div>
        </div>
    </div>
</div>
