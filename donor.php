<!-- Google Maps JavaScript API Assets -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy8_Ic4K9OEPV6P6aKdm0w95A3qvLFudE&libraries=places,geometry&callback=onGoogleMapsLoaded" async defer></script>

<!-- Donor Dashboard Panel -->
<!-- 1. OVERVIEW SECTION -->
<div id="overview-panel" class="dashboard-view-panel">
    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>My Physical Listings</h3>
                <div class="stat-number" id="statMyListings">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Active Matches</h3>
                <div class="stat-number" id="statMyMatches">0</div>
            </div>
        </div>
        <div class="glass-panel stat-card">
            <div class="stat-info">
                <h3>Completed Support</h3>
                <div class="stat-number" id="statCompletedDons">0</div>
            </div>
        </div>
    </div>

    <!-- Quick action layout -->
    <div class="dashboard-grid">
        <!-- Quick Action & Donor Coordination Hub Card -->
        <div class="glass-panel" style="padding: 30px; background: #FFFFFF; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <div class="card-header" style="margin-bottom: 16px;">
                    <div>
                        <h3 class="card-title" style="margin:0 0 4px 0;">Donor Contribution Hub</h3>
                        <p style="font-size:0.85rem; color:var(--color-text-muted); margin:0;">Donate physical materials, contribute monetary funds, or join volunteer shifts.</p>
                    </div>
                    <span class="badge badge-success">ACTIVE DONOR</span>
                </div>
                <p style="font-size: 0.9rem; color: var(--color-text-dark); line-height: 1.6; margin-bottom: 20px;">
                    List your surplus physical goods in the community pool, or browse direct requests from verified schools, hospitals, and child welfare institutions across Sri Lanka.
                </p>
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="#listings" class="btn btn-primary" style="padding: 12px 24px; font-weight: 800; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    🎁 Post Material Donation Item
                </a>
                <a href="#needs-catalogue" class="btn btn-secondary" style="padding: 12px 20px; font-weight: 700; font-size: 0.9rem; text-decoration: none;">
                    Browse Verified Requests
                </a>
            </div>
        </div>

        <!-- Announcements Panel -->
        <div class="glass-panel" style="padding: 30px; background: #FFFFFF;">
            <div class="card-header">
                <h3 class="card-title">Announcements</h3>
            </div>
            <div id="announcementsContainer" style="max-height: 420px; overflow-y: auto;">
                <!-- Filled dynamically by app.js -->
            </div>
        </div>
    </div>
</div>

<!-- 2. MY LISTINGS SECTION -->
<div id="listings-panel" class="dashboard-view-panel" style="display: none;">
    <!-- Post Available Physical Item Listing Form -->
    <div class="glass-panel" style="padding: 30px; background: #FFFFFF; margin-bottom: 24px;">
        <div class="card-header" style="flex-direction: column; align-items: flex-start; gap: 4px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <h3 class="card-title">Donate an Item</h3>
                <span style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700;">PHYSICAL DONATION</span>
            </div>
            <p style="font-size: 0.88rem; color: var(--color-text-muted); margin: 0;">Fill in the form below to submit an item you would like to donate.</p>
        </div>
        <form id="formPostDonation">
            <input type="hidden" id="donItemId" value="">
            
            <!-- 1. Category & 2. Item Name -->
            <div class="grid-cols-2">
                <div class="form-group" id="groupDonCategory">
                    <label class="form-label" for="donCategory">Category</label>
                    <select class="form-control form-select" id="donCategory" required>
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
                <div class="form-group" id="groupDonItemName">
                    <label class="form-label" for="donItemName">Item Name</label>
                    <input type="text" class="form-control" id="donItemName" placeholder="e.g. First Aid Kits / Rice Rations" required>
                </div>
            </div>

            <!-- 3. Quantity, 4. Unit of Measure, 5. Condition -->
            <div class="grid-cols-3" id="rowDonQtyUnitCond">
                <div class="form-group" id="groupDonQuantity">
                    <label class="form-label" for="donQuantity">Quantity</label>
                    <div class="quantity-stepper" style="display: flex; align-items: center; gap: 4px;">
                        <button type="button" class="btn btn-secondary btn-stepper" id="btnDonQtyDec" onclick="window.adjustDonQuantity && window.adjustDonQuantity(-1)" style="min-width: 38px; height: 42px; font-size: 1.2rem; font-weight: 800; border-radius: 6px; background: #EFECE6; border: 1px solid var(--color-border); cursor: pointer; color: var(--color-teal-primary); display: flex; align-items: center; justify-content: center;" title="Decrease quantity">−</button>
                        <input class="form-control" type="number" id="donQuantity" min="1" value="1" style="text-align: center; font-weight: 700; height: 42px;" required>
                        <button type="button" class="btn btn-secondary btn-stepper" id="btnDonQtyInc" onclick="window.adjustDonQuantity && window.adjustDonQuantity(1)" style="min-width: 38px; height: 42px; font-size: 1.2rem; font-weight: 800; border-radius: 6px; background: #EFECE6; border: 1px solid var(--color-border); cursor: pointer; color: var(--color-teal-primary); display: flex; align-items: center; justify-content: center;" title="Increase quantity">+</button>
                    </div>
                </div>
                <div class="form-group" id="groupDonUnit">
                    <label class="form-label" for="donUnit">Unit of Measure</label>
                    <select class="form-control form-select" id="donUnit">
                        <option value="Units">Units / Pieces</option>
                        <option value="kg">Kilograms (kg)</option>
                        <option value="g">Grams (g)</option>
                        <option value="L">Liters (L)</option>
                        <option value="mL">Milliliters (mL)</option>
                        <option value="Packs">Packs</option>
                        <option value="Boxes">Boxes</option>
                        <option value="Bags">Bags</option>
                        <option value="Bottles">Bottles</option>
                        <option value="Cans / Tins">Cans / Tins</option>
                        <option value="Cartons">Cartons</option>
                    </select>
                </div>
                <div class="form-group" id="groupDonCondition">
                    <label class="form-label" for="donCondition">Condition</label>
                    <select class="form-control form-select" id="donCondition">
                        <option value="Brand New">Brand New</option>
                        <option value="Used">Used</option>
                        <option value="Partially Used">Partially Used</option>
                    </select>
                    <div id="errDonCondition" class="validation-msg-error" style="display:none;"></div>
                </div>
            </div>

            <!-- 6. Item Photo / Spec Image -->
            <div class="form-group">
                <label class="form-label" for="itemPhotoUploadInput">Item Photo / Spec Image</label>
                <div style="display: flex; gap: 12px; align-items: center;">
                    <input type="file" id="itemPhotoUploadInput" class="form-control" style="padding: 8px 12px; flex-grow: 1;" accept="image/*,.png,.jpg,.jpeg" onchange="window.handleDonorItemPhotoUpload && window.handleDonorItemPhotoUpload(this)">
                    <input type="hidden" id="donPhotoUrl" value="">
                </div>
                <div id="errDonPhoto" class="validation-msg-error" style="display:none;"></div>
                <div id="itemPhotoPreview" style="margin-top: 10px; display: none;">
                    <img id="imgPreviewSource" src="" style="max-height: 140px; max-width: 100%; border-radius: var(--radius-sm); border: 2px solid var(--color-teal-primary); object-fit: contain;" alt="Preview">
                </div>
            </div>

            <!-- 7. Description -->
            <div class="form-group">
                <label class="form-label" for="donDescription">Description</label>
                <textarea class="form-control" id="donDescription" rows="2" placeholder="Item description and pickup availability..."></textarea>
            </div>

            <div id="overviewStatsGrid" style="display:none;"></div>
            <div id="smartMatchesContainer" style="display:none;"></div>

            <button class="btn btn-primary" type="submit" id="formSubmitBtn" style="width: 100%; font-size: 0.95rem; padding: 12px; font-weight: 800;">
                Submit
            </button>
        </form>
    </div>

    <!-- Listings Table Panel -->
    <div class="glass-panel" style="padding: 30px; margin-bottom: 24px; background: #FFFFFF;">
        <div class="card-header" style="flex-wrap:wrap; gap:12px; margin-bottom: 20px;">
            <div>
                <h3 class="card-title" style="margin:0 0 4px 0;">Manage Offered Material Listings</h3>
                <p style="color:var(--color-text-muted); font-size:0.85rem; margin:0;">Track and edit your physical donations listed in the community pool.</p>
            </div>
            
            <!-- Donor Filter Controls -->
            <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                <input type="text" id="filterDonorSearch" class="form-control" placeholder="Search my listings..." style="max-width:200px; font-size:0.85rem;" oninput="window.renderDonorListings && window.renderDonorListings()">
                <select id="filterDonorStatus" class="form-control form-select" style="max-width:140px; font-size:0.85rem;" onchange="window.renderDonorListings && window.renderDonorListings()">
                    <option value="all">All Statuses</option>
                    <option value="available">Available</option>
                    <option value="matched">Matched</option>
                    <option value="in_transit">In Transit</option>
                    <option value="completed">Completed</option>
                    <option value="pending_admin">Pending Admin</option>
                    <option value="rejected">Rejected</option>
                </select>
                <select id="filterDonorCategory" class="form-control form-select" style="max-width:240px; font-size:0.85rem;" onchange="window.renderDonorListings && window.renderDonorListings()">
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
                <select id="sortDonorOrder" class="form-control form-select" style="max-width:130px; font-size:0.85rem;" onchange="window.renderDonorListings && window.renderDonorListings()">
                    <option value="latest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                </select>
                <div id="donorSubmissionsCascadingFilterContainer" style="display:none;"><span id="donorSubmissionsCascadingFilterLabel"></span></div>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Material Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="donorListingsBody">
                    <!-- Filled dynamically by app.js -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 3. REQUESTS CATALOGUE SECTION (BROWSE RECEIVER REQUESTS) -->
<div id="needs-catalogue-panel" class="dashboard-view-panel" style="display: none;">
    <div class="glass-panel" style="padding: 30px; margin-bottom: 24px; background: #FFFFFF;">
        <div class="card-header" style="margin-bottom: 20px;">
            <div>
                <h3 class="card-title" style="margin:0 0 4px 0;">Browse Verified Receiver Requests</h3>
                <p style="font-size:0.85rem; color:var(--color-text-muted); margin:0;">Explore verified needs from schools, hospitals, elder care homes, and welfare organizations.</p>
            </div>
            <span style="font-size: 0.8rem; color: var(--color-primary); font-weight: 700;">APPROVED REQUESTS</span>
        </div>

        <!-- Multi-Filter Control Toolbar -->
        <div class="glass-panel" style="padding: 16px; margin-bottom: 24px; background: #FBF5DD; border-radius:8px;">
            <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <input type="text" id="searchDonorNeeds" class="form-control" placeholder="Search requests..." style="max-width: 180px; font-size:0.85rem;" oninput="window.renderDonorNeeds && window.renderDonorNeeds()">
                
                <!-- 1. Receiver Types Filter -->
                <select id="filterReceiverCategory" class="form-control form-select" style="max-width: 190px; font-size:0.85rem; font-weight:600;" onchange="window.renderDonorNeeds && window.renderDonorNeeds()">
                    <option value="all">All Receiver Types</option>
                    <option value="School / Educational Institute">🏫 Schools & Education</option>
                    <option value="Hospital / Healthcare Clinic">🏥 Hospitals & Healthcare</option>
                    <option value="Orphanage / Child Welfare">🧒 Orphanages & Child Care</option>
                    <option value="Elder Care Home">👵 Elder Care Homes</option>
                    <option value="Disaster Relief Organization">🚨 Disaster Relief Orgs</option>
                    <option value="Community / Welfare Organization">🤝 Community & Welfare</option>
                    <option value="Individual / Family in Need">🏠 Individuals & Families</option>
                </select>

                <!-- 2. Distinct Physical Items Filter -->
                <select id="filterPhysicalCategory" class="form-control form-select" style="max-width: 190px; font-size:0.85rem; font-weight:600;" onchange="window.selectPhysicalCategoryFilter ? window.selectPhysicalCategoryFilter(this.value) : (window.renderDonorNeeds && window.renderDonorNeeds())">
                    <option value="all">📦 All Physical Items</option>
                    <option value="Education Supplies">Education Supplies</option>
                    <option value="Medical Supplies">Medical Supplies</option>
                    <option value="Food & Nutrition">Food & Nutrition</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Electronics & IT Equipment">Electronics & IT Equipment</option>
                    <option value="Clothing & Personal Care">Clothing & Personal Care</option>
                    <option value="Household Essentials">Household Essentials</option>
                    <option value="Other Supplies">Other Supplies</option>
                </select>

                <!-- 3. Support Type Filter -->
                <select id="filterReqType" class="form-control form-select" style="max-width: 150px; font-size:0.85rem;" onchange="window.renderDonorNeeds && window.renderDonorNeeds()">
                    <option value="all">All Support Types</option>
                    <option value="physical">Physical Items</option>
                    <option value="monetary">Monetary Aid</option>
                    <option value="volunteer">Volunteer Shifts</option>
                </select>

                <!-- 4. District Filter -->
                <select id="filterReqDistrict" class="form-control form-select" style="max-width: 140px; font-size:0.85rem;" onchange="window.renderDonorNeeds && window.renderDonorNeeds()">
                    <option value="all">All Districts</option>
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
                    <option value="Monaragala">Monaragala</option>
                    <option value="Ratnapura">Ratnapura</option>
                    <option value="Kegalle">Kegalle</option>
                </select>

                <!-- 5. Sort Order -->
                <select id="sortCatalogueOrder" class="form-control form-select" style="max-width: 140px; font-size:0.85rem; font-weight:700;" onchange="window.renderDonorNeeds && window.renderDonorNeeds()">
                    <option value="latest">Latest Added First</option>
                    <option value="oldest">Oldest First</option>
                </select>
            </div>
        </div>

        <!-- Requests Grid -->
        <div class="grid-cols-3" id="donorNeedsGrid" style="gap: 20px;">
            <!-- Filled dynamically by app.js -->
        </div>
    </div>
</div>

<!-- 4. DONATION PROCESS SECTION -->
<div id="matching-panel" class="dashboard-view-panel" style="display: none;">
    <h2 style="font-size: 1.35rem; font-weight: 800; color: #0F172A; margin: 0 0 20px 0;">Donation Process</h2>
    <div id="donorMatchesContainer">
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
                <p class="chat-empty-text" style="font-size:0.85rem; max-width:320px; margin:0;">Choose an organisation from the list on the left to view messages and coordinate donation details.</p>
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