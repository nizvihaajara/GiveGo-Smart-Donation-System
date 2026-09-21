<!-- Google Maps JavaScript API Assets -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy8_Ic4K9OEPV6P6aKdm0w95A3qvLFudE&libraries=places,geometry&callback=onGoogleMapsLoaded" async defer></script>

<!-- Receiver Dashboard Panel -->
<!-- 1. OVERVIEW SECTION -->
<div id="overview-panel" class="dashboard-view-panel">
    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>My Requests</h3>
                <div class="stat-number" id="statMyRequests">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Matched Offers</h3>
                <div class="stat-number" id="statReceiverMatches">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Utilisation Pending</h3>
                <div class="stat-number" id="statPendingEvidence">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Fulfillment Rate</h3>
                <div class="stat-number" id="statFulfillRate">0%</div>
            </div>
        </div>
    </div>

    <!-- Quick action layout -->
    <div class="dashboard-grid">
        <!-- Quick Action & Hub Card -->
        <div class="glass-panel" style="padding: 30px; background: #FFFFFF; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div class="card-header" style="margin-bottom: 16px;">
                    <div>
                        <h3 class="card-title" style="margin:0 0 4px 0;">Receiver Coordination Hub</h3>
                        <p style="font-size:0.85rem; color:var(--color-text-muted); margin:0;">Create and manage material, monetary, and volunteer needs for your organization.</p>
                    </div>
                    <span class="badge badge-success">ACTIVE PORTAL</span>
                </div>
                <p style="font-size: 0.9rem; color: var(--color-text-dark); line-height: 1.6; margin-bottom: 20px;">
                    Submit verified requirements to reach compassionate donors across Sri Lanka. Every request undergoes swift administrative review before publication in the community catalogue.
                </p>
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="#requests" class="btn btn-primary" style="padding: 12px 24px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    ➕ Create New Material Request
                </a>
                <a href="#available-items" class="btn btn-secondary" style="padding: 12px 20px; font-weight: 700; font-size: 0.9rem; text-decoration: none;">
                    Browse Available Donations
                </a>
            </div>
        </div>

        <!-- Announcements Panel -->
        <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
            <div class="card-header">
                <h3 class="card-title">System Announcements</h3>
            </div>
            <div id="announcementsContainer" style="max-height: 420px; overflow-y: auto;">
                <!-- Filled dynamically by app.js -->
            </div>
        </div>
    </div>
</div>

<!-- 2. MY REQUESTS SECTION -->
<div id="requests-panel" class="dashboard-view-panel" style="display: none;">
    <!-- Post New Request Card -->
    <div class="glass-panel" style="padding: 30px; background: #FFFFFF; margin-bottom: 24px;">
        <div class="card-header" style="margin-bottom: 20px;">
            <div>
                <h3 class="card-title" style="margin:0 0 4px 0;">Create Donation Request</h3>
                <p style="font-size:0.85rem; color:var(--color-text-muted); margin:0;">Fill in the form below to request physical items, monetary grants, or volunteer manpower.</p>
            </div>
            <span style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700;">ADMIN REVIEW REQUIRED</span>
        </div>
        <form id="formRequestMaterials">
            <!-- 1. Request Type (At the very top) -->
            <div class="form-group" id="groupReqType">
                <label class="form-label" for="reqType">Request Type</label>
                <select class="form-control form-select" id="reqType" required style="font-weight: 700;">
                    <option value="physical">Physical Item Request</option>
                    <option value="monetary">Monetary Donation Request</option>
                    <option value="volunteer">Volunteer Support Request</option>
                </select>
            </div>

            <!-- 2. Category (Below Request Type - Only visible for Physical items) -->
            <div class="form-group" id="groupReqCategory">
                <label class="form-label" for="reqCategory">Category</label>
                <select class="form-control form-select" id="reqCategory" required>
                    <option value="Education Supplies">Education Supplies</option>
                    <option value="Medical Supplies">Medical Supplies</option>
                    <option value="Food & Nutrition">Food & Nutrition</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Electronics & IT Equipment">Electronics & IT Equipment</option>
                    <option value="Clothing & Personal Care">Clothing & Personal Care</option>
                    <option value="Household Essentials">Household Essentials</option>
                    <option value="Other Supplies">Other Supplies</option>
                </select>
            </div>

            <!-- 3. Item / Need Title (Below Category - Only visible for Physical items) -->
            <div class="form-group" id="groupReqItemName">
                <label class="form-label" id="lblReqItemName" for="reqItemName">Item / Need Title</label>
                <input type="text" class="form-control" id="reqItemName" placeholder="e.g. ICU Hospital Linens / Rice Packs" required>
            </div>

            <!-- 4. Physical Request Specific Fields -->
            <div id="secReqPhysical">
                <div class="grid-cols-3">
                    <div class="form-group">
                        <label class="form-label">Unit of Measure</label>
                        <select class="form-control form-select" id="reqUnit">
                            <option value="Units">Units / Pieces</option>
                            <option value="kg">Kilograms (kg)</option>
                            <option value="g">Grams (g)</option>
                            <option value="L">Liters (L)</option>
                            <option value="Packs">Packs / Bags</option>
                            <option value="Boxes">Boxes / Crates</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Required Quantity</label>
                        <input type="number" class="form-control" id="reqQuantity" min="1" value="10">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Acceptable Condition</label>
                        <select class="form-control form-select" id="reqCondition">
                            <option value="Brand New">Brand New Only</option>
                            <option value="Gently Used">Gently Used / Good</option>
                            <option value="Any Condition">Any Usable Condition</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 5. Monetary Request Specific Fields -->
            <div id="secReqMonetary" style="display: none;">
                <div class="grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Required Amount (LKR)</label>
                        <input type="number" class="form-control" id="reqAmount" min="500" step="500" placeholder="e.g. 50000">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Target Deadline</label>
                        <input type="date" class="form-control" id="reqDeadline">
                    </div>
                </div>
                <div class="glass-panel" style="padding: 16px; margin-bottom: 20px; background: #FBF5DD; border: 1px solid var(--color-border-dark); border-radius: 8px;">
                    <h4 style="font-size: 0.9rem; color: var(--color-primary); margin-bottom: 6px;">Verified Receiver Bank Details</h4>
                    <div id="recBankDetailsDisplay" style="font-size: 0.85rem; color: var(--color-text-body);">
                        Bank information from your admin-verified profile will be shown to verified donors for direct fund transfers.
                    </div>
                </div>
            </div>

            <!-- 6. Volunteer Request Specific Fields -->
            <div id="secReqVolunteer" style="display: none;">
                <div id="hospitalVolunteerAlert" class="badge badge-warning" style="display: none; width: 100%; padding: 10px; margin-bottom: 16px; font-size: 0.8rem; text-transform: none;">
                    Hospital Notice: Standard volunteer requests are restricted for hospitals. Submitting this request flags it for Administrator approval of Non-Clinical Support.
                </div>
                <div class="grid-cols-3">
                    <div class="form-group">
                        <label class="form-label">Volunteers Needed</label>
                        <input type="number" class="form-control" id="reqVolunteersCount" min="1" value="5">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Activity Date & Time</label>
                        <input type="datetime-local" class="form-control" id="reqVolDateTime">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Location / District</label>
                        <input type="text" class="form-control" id="reqVolLocation" placeholder="e.g. Kandy Premises">
                    </div>
                </div>
                <div class="grid-cols-2">
                    <div class="form-group">
                        <label class="form-label">Skill / Age Requirements</label>
                        <input type="text" class="form-control" id="reqVolSkills" placeholder="e.g. Basic Gardening, 18+ years">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Equipment Supply Mode</label>
                        <select class="form-control form-select" id="reqEquipmentMode">
                            <option value="provided_by_org">Provided by Organisation</option>
                            <option value="volunteers_must_bring">Volunteers Must Bring Equipment</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Equipment Needed (Specify items and required quantities)</label>
                    <input type="text" class="form-control" id="reqVolEquipmentList" placeholder="e.g. 3 Ekel Brooms, 2 Garden Cutters, 5 Gloves">
                </div>
            </div>

            <!-- 7. Purpose / Detailed Instructions -->
            <div class="form-group">
                <label class="form-label">Purpose / Detailed Instructions</label>
                <textarea class="form-control" id="reqDescription" rows="3" placeholder="Explain the cause, beneficiaries, and safety guidelines..." required></textarea>
            </div>

            <button class="btn btn-primary" type="submit" style="width: 100%; font-size: 1rem; font-weight: 800; padding: 12px;">
                Submit Request for Admin Approval
            </button>
        </form>
    </div>

    <!-- Requests Table Panel -->
    <div class="glass-panel" style="padding: 30px; margin-bottom: 24px; background: #FFFFFF;">
        <div class="card-header">
            <h3 class="card-title">Manage Published & Pending Requests</h3>
            <!-- Receiver Filter Bar -->
            <div style="display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap;">
                <input class="form-control" type="text" id="filterReceiverSearch" oninput="window.renderReceiverRequests && window.renderReceiverRequests()" placeholder="Search my requests..." style="max-width: 200px;">
                <select class="form-control form-select" id="filterReceiverStatus" onchange="window.renderReceiverRequests && window.renderReceiverRequests()" style="max-width: 180px;">
                    <option value="all">All Statuses</option>
                    <option value="pending_admin">Pending Admin</option>
                    <option value="published">Approved / Published</option>
                    <option value="rejected">Rejected by Admin</option>
                    <option value="fulfilled">Completed</option>
                </select>
                <select class="form-control form-select" id="filterReceiverCategory" onchange="window.renderReceiverRequests && window.renderReceiverRequests()" style="max-width: 250px;">
                    <option value="all">All Categories</option>
                    <option value="Education Supplies">Education Supplies</option>
                    <option value="Medical Supplies">Medical Supplies</option>
                    <option value="Food & Nutrition">Food & Nutrition</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Electronics & IT Equipment">Electronics & IT Equipment</option>
                    <option value="Clothing & Personal Care">Clothing & Personal Care</option>
                    <option value="Household Essentials">Household Essentials</option>
                    <option value="Other Supplies">Other Supplies</option>
                </select>
                <select class="form-control form-select" id="sortReceiverOrder" onchange="window.renderReceiverRequests && window.renderReceiverRequests()" style="max-width: 180px; font-weight:700;">
                    <option value="latest">Latest Added First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Target</th>
                        <th>Fulfilled</th>
                        <th>Remaining to Receive</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="receiverRequestsBody">
                    <!-- Filled dynamically by app.js -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 3. MATCHING SECTION (Donation Process) -->
<div id="matching-panel" class="dashboard-view-panel" style="display: none;">
    <h2 style="font-size: 1.35rem; font-weight: 800; color: #0F172A; margin: 0 0 20px 0;">Donation Process</h2>
    <div id="receiverMatchesContainer">
        <!-- Filled dynamically by app.js -->
    </div>
    <div id="liveSimulatedMap" style="display:none;"></div>
</div>

<!-- 5. CHAT/MESSAGES SECTION (Two-Panel ChatGPT Style) -->
<div id="chat-panel" class="dashboard-view-panel" style="display: none;">
    <div class="chat-container-two-panel glass-panel" style="min-height:540px;">
        <!-- Left Sidebar: Conversations List -->
        <aside class="chat-sidebar-pane" id="chatSidebarPane">
            <div class="chat-sidebar-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <h3 class="chat-sidebar-title" style="margin:0; font-size:1.1rem; color:var(--color-primary);">Messages</h3>
                <span class="badge badge-info" id="chatConversationsCount" style="font-size:0.75rem;">0</span>
            </div>
            <div style="margin-bottom:12px;">
                <input type="text" id="chatSearchInput" class="form-control chat-search-input" placeholder="Search conversations..." oninput="window.filterDonationChatList && window.filterDonationChatList(this.value)">
                <input type="hidden" id="chatSearchConversations">
            </div>
            <div class="chat-conversations-list" id="chatMatchesList">
                <!-- Populated dynamically by app.js -->
            </div>
        </aside>

        <!-- Right Main: Active Conversation -->
        <section class="chat-main-pane">
            <!-- Active Conversation Window (Shown when conversation is selected) -->
            <div id="chatActiveWindow" class="chat-active-window" style="display: none; flex-direction:column; height:100%;">
                <div class="chat-active-header" style="display:flex; justify-content:space-between; align-items:center; padding:12px 18px; border-bottom:1px solid var(--color-border); background:#FFFFFF;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <button type="button" id="btnChatBackToList" class="btn btn-secondary" style="display:none; padding:4px 8px; font-size:0.8rem;" onclick="window.backToChatList && window.backToChatList()">←</button>
                        <div class="profile-avatar chat-active-avatar" id="chatActiveAvatar" style="width:38px; height:38px; border-radius:50%; background:var(--color-primary); color:#FFF; display:flex; align-items:center; justify-content:center; font-weight:800;">U</div>
                        <div id="chatPeerAvatar" style="display:none;"></div>
                        <div>
                            <h4 class="chat-active-peer-name" id="chatActiveRecipientName" style="margin:0; font-size:0.95rem; font-weight:800; color:var(--color-primary);">Select Conversation</h4>
                            <span id="chatPeerName" style="display:none;"></span>
                            <div class="chat-active-meta" id="chatPeerRole" style="font-size:0.75rem; color:var(--color-text-muted);">Active Discussion</div>
                            <span id="chatPeerMeta" style="display:none;"></span>
                        </div>
                    </div>
                </div>

                <!-- Context item bar -->
                <div id="chatDonationContextBar" style="background:#FBF5DD; padding:8px 16px; border-bottom:1px solid var(--color-border); display:flex; justify-content:space-between; align-items:center; font-size:0.82rem;">
                    <div>
                        <strong style="color:var(--color-primary);">Item:</strong> <span id="chatContextItemName">-</span>
                        <span id="chatContextStatusBadge" class="badge badge-info" style="margin-left:6px; font-size:0.7rem;">Discussion</span>
                    </div>
                    <button type="button" id="btnChatProposeSchedule" class="btn btn-secondary" style="font-size:0.75rem; padding:4px 10px; font-weight:700;" onclick="window.handleChatProposeSchedule && window.handleChatProposeSchedule()">Schedule Handover</button>
                </div>

                <div class="chat-messages-area" id="chatMessagesContainer" style="flex:1; overflow-y:auto; padding:16px;">
                    <!-- Populated dynamically by app.js -->
                </div>

                <form class="chat-input-bar" id="formSendMessage" onsubmit="event.preventDefault(); window.sendActiveChatMessage && window.sendActiveChatMessage();" style="display:flex; gap:8px; padding:12px; border-top:1px solid var(--color-border); background:#FFFFFF;">
                    <input type="text" class="form-control chat-text-input" id="inputChatMessage" placeholder="Type a message..." autocomplete="off" required style="flex:1;">
                    <button type="submit" class="btn btn-primary chat-send-btn" id="btnSendChatMessage" style="padding:8px 18px; font-weight:800;">
                        <span>Send</span>
                    </button>
                </form>
            </div>

            <!-- Empty Placeholder (Shown when NO conversation is selected) -->
            <div id="chatEmptyPlaceholder" class="chat-empty-placeholder" style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; padding:40px; text-align:center; color:var(--color-text-muted);">
                <div class="chat-empty-icon-wrap" style="font-size:2.5rem; margin-bottom:12px;">💬</div>
                <h3 class="chat-empty-title" style="font-size:1.1rem; color:var(--color-primary); margin:0 0 6px 0;">Select a Conversation</h3>
                <p class="chat-empty-text" style="font-size:0.85rem; max-width:320px; margin:0;">Choose a donor from the list on the left to view messages and coordinate donation details.</p>
            </div>
        </section>
    </div>
</div>

<!-- 6. DIRECT ADMIN SUPPORT HELPDESK PANEL -->
<div id="admin-chat-panel" class="dashboard-view-panel" style="display: none;">
    <div class="glass-panel" style="padding: 24px; background: #FFFFFF; max-width: 900px; margin: 0 auto; border-radius: 12px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1px solid var(--color-border);">
            <div>
                <h2 style="font-size: 1.4rem; font-weight: 800; color: var(--color-primary); margin: 0 0 4px 0;">Official Admin Support Helpdesk</h2>
                <p style="color: var(--color-text-muted); font-size: 0.85rem; margin: 0;">Direct communication with the GiveGo Administration team.</p>
            </div>
            <span id="userInquiryStatusBadge" class="badge badge-success">ACTIVE SUPPORT</span>
        </div>
        
        <div id="userInquiryMessagesContainer" style="height: 420px; overflow-y: auto; padding: 16px; background: #F8FAFC; border-radius: 8px; border: 1px solid var(--color-border); display: flex; flex-direction: column; gap: 12px; margin-bottom: 16px;">
            <!-- Populated dynamically by app.js -->
        </div>

        <form id="formUserInquiryReply" onsubmit="event.preventDefault(); window.sendUserInquiryMessage && window.sendUserInquiryMessage();" style="display: flex; gap: 10px;">
            <input type="text" id="inputUserInquiryReply" class="form-control" placeholder="Type your message to administrator..." required style="flex: 1;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 22px; font-weight: 800;">Send Message</button>
        </form>
    </div>
</div>
 