<!-- action buttons -->
<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right  " id="list-page-actions-container">
    <div id="list-page-actions">
        <!--SEARCH BOX-->
        <div class="header-search" id="header-search">
            <i class="sl-icon-magnifier"></i>
            <input type="text" class="form-control search-records list-actions-search" data-url="http://growcrm.test/payments/search?action=search&amp;paymentresource_id=&amp;paymentresource_type=" data-type="form" data-ajax-type="post" data-form-id="header-search" id="search_query" name="search_query" placeholder="Search">
        </div>
        
        <!--TOGGLE STATS-->
        <button type="button" data-toggle="tooltip" title="Quick Stats" class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-stats-widget update-user-ux-preferences" data-type="statspanel" data-progress-bar="hidden" data-url-temp="http://growcrm.test/team/updatepreferences" data-url="" data-target="list-pages-stats-widget">
            <i class="ti-stats-up"></i>
        </button>
        
        <!--FILTERING-->
        <button type="button" data-toggle="tooltip" title="Filter" class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-side-panel" data-target="sidepanel-filter-payments">
            <i class="mdi mdi-filter-outline"></i>
        </button>
        
        <!--ADD NEW ITEM-->
        <button type="button" class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form " data-toggle="modal" data-target="#commonModal" data-url="http://growcrm.test/payments/create?paymentresource_id=&amp;paymentresource_type=" data-loading-target="commonModalBody" data-modal-title="Add A New Payment" data-action-url="http://growcrm.test/payments?paymentresource_id=&amp;paymentresource_type=" data-action-method="POST" data-action-ajax-class="" data-modal-size="" data-action-ajax-loading-target="commonModalBody" data-save-button-class="" data-project-progress="0">
            <i class="ti-plus"></i>
        </button>
        <!--add new button (link)-->
    </div>
</div>
<!-- action buttons -->