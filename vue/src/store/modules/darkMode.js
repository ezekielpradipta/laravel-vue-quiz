const darkMode = {
    namespaced: true,
    state: {
        display: "dark",
    },
    mutations: {
        SET_DISPLAY: (state, display) => {
            state.display = display;
        },
    },
    actions: {
        async setDisplay({ commit }, display) {
            if (display === "dark") {
                document.body.classList.add("dark");
            } else {
                document.body.classList.remove("dark");
            }
            commit("SET_DISPLAY", display);
        },
    },
    getters: { getDisplay: (state) => state.display },
};
export default darkMode;
