<template>
    <header class="topbar">
        <div class="left-top-bar">
            <a class="nav-toggler d-md-none d-sm-block" href="javascript:void(0)" role="button">
                <i class="fa-solid fa-bars"></i>
            </a>
            <div class="navbar-brand">
                <p class="brand m-0 p-0">CodeCloud HRM</p>
            </div>
            <a class="nav-toggler d-md-none d-sm-block" href="javascript:void(0)">
                <i class="fa-solid fa-ellipsis"></i>
            </a>
        </div>
        <div class="right-top-bar"></div>
    </header>
</template>

<style scoped>
    .brand{
        font-family: "Montserrat";
        font-weight: 700;
        color: #fff;
    }

    .topbar{
        position: fixed;
        width: 100%;
        z-index: 50;
        transition: .2s ease-in;
        box-shadow: 1px 0 7px rgb(0 0 0 / 5%);
        background: #fff;
        height: 64px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }
    .left-top-bar{
        width: 250px;
        height: 64px;
        background: rgb(83, 82, 82);
    }

    .nav-toggler{
        color: #fff;
        padding: 0 15px;
    }

    .navbar-brand{
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0 15px;
        height: 100%;
    }

    @media screen and (max-width: 991px) {
        .left-top-bar{
            width: 100%;
        }
        .left-top-bar{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }        
        .navbar-brand{
            min-width: 100px;
            max-width: 100px;
            justify-content: center;
        }
    }
</style>