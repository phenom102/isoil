<style>
    :root {
        --primary-color: #0275d8;
        --secondary-color: #5bc0de;
        --success-color: #5cb85c;
        --danger-color: #d9534f;
        --bg-light: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f4f7f6;
    }

    .px-navbar {
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,.08);
        border: none;
    }

    .px-nav {
        background: #2c3e50 !important;
    }

    .px-nav-content {
        padding-top: 20px;
    }

    .px-nav-box {
        border: none !important;
        margin-bottom: 10px;
    }

    .px-nav-box .btn-outline {
        border-color: rgba(255,255,255,0.1);
        color: #ecf0f1;
        text-align: left;
        padding: 12px 20px;
        transition: all 0.3s;
    }

    .px-nav-box .btn-outline:hover {
        background: rgba(255,255,255,0.05);
        border-color: var(--primary-color);
        color: #fff;
    }

    .px-nav-box .btn-primary {
        background: var(--primary-color);
        border: none;
    }

    .px-content {
        padding: 30px;
    }

    .page-header {
        margin-bottom: 30px;
        border-bottom: 1px solid #e1e4e8;
        padding-bottom: 15px;
    }

    .panel {
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        border: none;
        margin-bottom: 30px;
    }

    .panel-heading {
        background: #fff !important;
        border-bottom: 1px solid #f0f0f0 !important;
        padding: 15px 25px !important;
        border-radius: 8px 8px 0 0 !important;
    }

    .panel-title {
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
    }

    .table-primary {
        border-radius: 0 0 8px 8px;
        overflow: hidden;
    }

    .table thead th {
        background: #fcfcfc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        font-weight: 700;
        color: #777;
        border-bottom: 2px solid #eee !important;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-weight: 500;
    }

    .badge-success { background-color: var(--success-color); }
    .badge-danger { background-color: var(--danger-color); }

    .px-footer {
        background: transparent;
        border: none;
        padding: 20px 0;
    }
</style>
