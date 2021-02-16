import Vue from "vue";

Object.defineProperties(Vue.prototype, {
    $routes: {
        get: () =>
            function(name, params = null) {
                let route = this.$page.props.routes[name];
                if (!params) {
                    if (route == "/") {
                        return "/";
                    }
                    return `/${route}`;
                } else {
                    let nuw = "";
                    route = route.split("/");
                    route.map((item, index) => {
                        let count = 0;
                        if (item.includes("{")) {
                            nuw += `${params[count]}`;
                            if (index + 1 !== route.length) {
                                nuw += "/";
                            }
                            count++;
                        } else {
                            nuw += `${item}/`;
                        }
                    });
                    return `/${nuw}`;
                }
            },
    },
    $url: {
        get: () =>
            function(name, params = null) {
                return `${this.$page.props.url}/${name}`;
            },
    },
});

window.debounce = function(fn, delay) {
    let timeoutID = null;
    return function() {
        clearTimeout(timeoutID);
        timeoutID = setTimeout(() => fn.apply(this, arguments), delay);
    };
};
