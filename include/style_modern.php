<style>
    :root {
        --primary-color: #2c3e50;
        --accent-color: #3498db;
        --success-color: #27ae60;
        --danger-color: #e74c3c;
        --bg-light: #f4f7f6;
        --panel-bg: #ffffff;
        --text-dark: #334155;
        --text-muted: #64748b;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: var(--bg-light);
        color: var(--text-dark);
        -webkit-font-smoothing: antialiased;
    }

    /* Navbar & Brand */
    .px-navbar {
        background: #fff;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        border: none;
        height: 64px;
    }

    .px-navbar .navbar-brand {
        font-weight: 700;
        letter-spacing: -0.025em;
        font-size: 1.25rem;
    }

    /* Sidebar Navigation */
    .px-nav {
        background: var(--primary-color) !important;
        box-shadow: 4px 0 10px rgba(0,0,0,0.05);
    }

    .px-nav-content {
        padding-top: 24px;
    }

    .px-nav-box {
        border: none !important;
        margin: 0 12px 8px 12px;
    }

    .px-nav-box .btn-outline {
        border: none !important;
        background: transparent;
        color: #94a3b8;
        text-align: left;
        padding: 12px 16px;
        border-radius: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-weight: 500;
        display: flex;
        align-items: center;
    }

    .px-nav-box .btn-outline:hover {
        background: rgba(255,255,255,0.05);
        color: #fff;
    }

    .px-nav-box.active .btn-outline,
    .px-nav-box .btn-primary {
        background: var(--accent-color) !important;
        color: #fff !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .px-nav-icon {
        margin-right: 12px;
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    /* Content Area */
    .px-content {
        padding: 32px 40px;
    }

    .page-header {
        margin-bottom: 32px;
        border: none;
        padding-bottom: 0;
    }

    .page-header h1 {
        font-weight: 800;
        letter-spacing: -0.05em;
        color: var(--primary-color);
        margin: 0;
        font-size: 1.875rem;
        display: flex;
        align-items: center;
    }

    .page-header-icon {
        margin-right: 16px;
        color: var(--accent-color);
    }

    /* Panels & Cards */
    .panel {
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        border: 1px solid #e2e8f0;
        margin-bottom: 32px;
        background: var(--panel-bg);
        overflow: hidden;
    }

    .panel-heading {
        background: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 20px 24px !important;
    }

    .panel-title {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1rem;
        letter-spacing: -0.01em;
    }

    /* Tables */
    .table-primary {
        border: none;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: var(--text-muted);
        border-bottom: 1px solid #e2e8f0 !important;
        padding: 16px 24px !important;
    }

    .table tbody td {
        padding: 16px 24px !important;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.875rem;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badges & Labels */
    .badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .label {
        padding: 4px 10px;
        border-radius: 9999px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .label-success { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .label-danger { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    /* Custom Buttons */
    .btn {
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.2s;
    }

    .btn-primary {
        background: var(--accent-color);
        border-color: var(--accent-color);
    }

    .btn-outline.btn-rounded {
        border-radius: 9999px;
    }

    .filter-section {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .px-footer {
        background: transparent;
        border-top: 1px solid #e2e8f0;
        padding: 24px 0;
        margin-top: 40px;
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
