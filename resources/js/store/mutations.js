export default {
    loginUser(state, payload) {
        state.user = {};
        state.user.name = payload.name;
        state.user.email = payload.email;
        localStorage.setItem("loggedIn", JSON.stringify(true));
    },
    logoutUser(state) {
        state.user = null;
        localStorage.setItem("loggedIn", JSON.stringify(false));
    },
    startProcessing(state) {
        state.processing = true;
    },
    endProcessing(state) {
        state.processing = false;
    },
    validationError(state, payload) {
        state.validationErrors = payload;
    },
};
