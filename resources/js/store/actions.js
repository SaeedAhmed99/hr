import router from "../router.js";

export default {
    loginUser(context, payload) {
        context.commit("startProcessing");
        axios
            .post("/login", payload)
            .then(async (response) => {
                context.commit("loginUser", response.data);
                context.commit("validationError", {});
                router.push({ name: "dashboard" });
            })
            .catch((error) => {
                if (error.response?.data) {
                    context.commit("validationError", error.response.data.errors);
                }
            })
            .finally(() => context.commit("endProcessing"));
    },
    async getUser(context) {
        await axios
            .get("/api/user")
            .then((response) => {
                context.commit("loginUser", response.data);
            })
            .catch((error) => {
                context.commit("logoutUser");
            });
    },
};
