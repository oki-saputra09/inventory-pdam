<style>
    :root {
        --primary: #86B6F6;
        --primary-dark: #0d6f9d;
        --primary-soft: #e9f7fd;
        --sidebar: #0f5f86;
        --sidebar-dark: #0b4f70;
    }

    .layout {
        width: 100%;
        height: 100vh;
        display: flex;
    }

    .sidebar {
        width: 270px;
        background: linear-gradient(180deg, var(--sidebar), var(--sidebar-dark));
        color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        padding: 24px 18px;
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1100;
        box-shadow: 4px 0 18px rgba(0, 0, 0, 0.12);
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.22);
        border-radius: 999px;
    }

    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.28);
        opacity: 0;
        visibility: hidden;
        transition: 0.25s ease;
        z-index: 1090;
    }

    .sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 6px 8px 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.14);
        margin-bottom: 22px;
    }

    .brand-logo {
        width: 56px;
        height: 56px;
        flex-shrink: 0;
    }

    .brand-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        filter:
            drop-shadow(0 0 2px rgba(255, 255, 255, 0.9))
            drop-shadow(0 0 7px rgba(255, 255, 255, 0.7));
    }

    .brand-text h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.2;
    }

    .brand-text span {
        font-size: .78rem;
        opacity: .9;
    }

    .menu-title {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .8px;
        opacity: .8;
        margin: 20px 10px 10px;
        text-transform: uppercase;
    }

    .menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu li {
        margin-bottom: 8px;
    }

    .menu a,
    .logout-btn {
        width: 100%;
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: #fff;
        padding: 12px 14px;
        border-radius: 14px;
        font-size: .95rem;
        font-weight: 600;
        transition: .2s ease;
        text-align: left;
    }

    .menu a:hover,
    .menu a.active,
    .logout-btn:hover {
        background: rgba(255, 255, 255, 0.14);
    }

    .menu a i,
    .logout-btn i {
        font-size: 1.05rem;
    }

    .logout-form {
        margin: 0;
    }

    .menu-toggle {
        width: 46px;
        height: 46px;
        border: 1px solid #dce8ef;
        background: #fff;
        border-radius: 12px;
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        cursor: pointer;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
    }

    .menu-toggle:hover {
        background: var(--primary-soft);
    }
</style>