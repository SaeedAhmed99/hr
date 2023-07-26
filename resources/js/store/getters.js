export default {
    getLoggedInUser(state){
        return state.user;
    },
    isAuthenticated(state){
        return !!state.user;
    },
    getValidationErrors(state){
        return state.validationErrors;
    },
    isProcssing(state){
        return state.processing;
    }
}