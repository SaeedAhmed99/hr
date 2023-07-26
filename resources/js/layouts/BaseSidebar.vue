<template>
    <aside class="left-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="in">
                <li class="nav-small-cap">This is top</li>
                <li class="sidebar-item">
                    <router-link to="/" is="span" class="sidebar-link has-arrow" href="javascript:void(0)" @click.self="toogleMenu"> Dashboard </router-link>
                    <ul class="first-level collapse" id="firstColumn">
                        <li class="sidebar-item">
                            <router-link to="/home" class="sidebar-link" href="">Overview</router-link>
                        </li>
                        <li class="sidebar-item">
                            <router-link to="/report" class="sidebar-link" href="">Report</router-link>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item selected">
                    <router-link to="/employee" class="sidebar-link" href=""> Employee </router-link>
                </li>
                <li class="sidebar-item selected">
                    <router-link to="/hr-system-setup" class="sidebar-link" href=""> HR System Setup </router-link>
                </li>
                <li class="sidebar-item selected">
                    <router-link to="/site-setting" class="sidebar-link" href=""> Site Setting </router-link>
                </li>
            </ul>
        </nav>
    </aside>
</template>

<script setup>
let toogleMenu = (e) => {
    e.preventDefault();
    e.currentTarget.nextElementSibling.classList.toggle("show");
};
</script>

<style scoped>
a {
    text-decoration: none;
}

.left-sidebar {
    position: fixed;
    width: 250px;
    height: 100%;
    top: 0;
    left: 0;
    padding-top: 64px;
    z-index: 10;
    background: #fff;
    box-shadow: 1px 0 20px rgba(0, 0, 0, 0.08);
    transition: 0.2s ease-in;
    background: #233242;
}

.sidebar-nav {
    height: 100%;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar-nav ul .sidebar-item {
    width: 250px;
}

.sidebar-nav ul {
    margin: 0;
    padding: 0;
}

.sidebar-nav ul .sidebar-item .sidebar-link {
    padding: 12px 15px;
    display: flex;
    white-space: nowrap;
    align-items: center;
    position: relative;
    line-height: 25px;
    font-size: 16px;
    opacity: 0.6;
    color: #fff;
    border-left: 3px solid transparent;
}

.sidebar-nav ul .nav-small-cap {
    font-size: 12px;
    padding: 12px 15px;
    white-space: nowrap;
    display: flex;
    align-items: center;
    line-height: 30px;
    margin-top: 10px;
    color: #fff;
    opacity: 0.3;
    text-transform: uppercase;
}

.sidebar-nav ul li {
    list-style: none;
}

.sidebar-nav > #sidebarnav > .sidebar-item > .sidebar-link.active {
    background: rgba(0, 0, 0, 0.1);
    border-left: 2px solid #137eff;
    opacity: 1;
}

.sidebar-nav > #sidebarnav > .sidebar-item > .sidebar-link:hover {
    background: rgba(0, 0, 0, 0.1);
    opacity: 1;
}

.sidebar-nav ul .sidebar-item .sidebar-link.active {
    font-weight: 400;
}

.sidebar-nav ul .sidebar-item .sidebar-item a.active {
    opacity: 1;
}

.sidebar-nav ul .sidebar-item .first-level .sidebar-item .sidebar-link {
    font-size: 14px;
    padding: 10px 20px;
}

.sidebar-nav ul .sidebar-item .first-level .sidebar-item .sidebar-link:hover,
.sidebar-nav ul .sidebar-item .first-level .sidebar-item.active .sidebar-link {
    opacity: 1;
}

.collapse {
    display: none;
}

.sidebar-nav ul .sidebar-item .sidebar-link.active + .collapse,
.sidebar-nav ul .sidebar-item .sidebar-link + .collapse.show {
    display: block;
}

@media screen and (max-width: 991px) {
    .left-sidebar {
        left: -250px;
    }
}
</style>