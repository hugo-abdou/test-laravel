import Vue from "vue";

Vue.filter("capitalize", function(value) {
    if (!value) return "";
    value = value.toString();
    let arr = value.split(" ");
    let capitalized_array = [];
    arr.forEach(word => {
        let capitalized = word.charAt(0).toUpperCase() + word.slice(1);
        capitalized_array.push(capitalized);
    });
    return capitalized_array.join(" ");
});

Vue.filter("title", function(value, replacer = "_") {
    if (!value) return "";
    value = value.toString();

    let arr = value.split(replacer);
    let capitalized_array = [];
    arr.forEach(word => {
        let capitalized = word.charAt(0).toUpperCase() + word.slice(1);
        capitalized_array.push(capitalized);
    });
    return capitalized_array.join(" ");
});

Vue.filter("truncate", function(value, limit) {
    if (value && value.length > limit) return value.substring(0, limit) + "...";
    else return value;
});

Vue.filter("tailing", function(value, tail) {
    return value + tail;
});

Vue.filter("time", function(value, is24HrFormat = false) {
    if (value) {
        const date = new Date(Date.parse(value));
        let hours = date.getHours();
        const min = (date.getMinutes() < 10 ? "0" : "") + date.getMinutes();
        if (!is24HrFormat) {
            const time = hours > 12 ? "AM" : "PM";
            hours = hours % 12 || 12;
            return hours + ":" + min + " " + time;
        }
        return hours + ":" + min;
    }
});

Vue.filter("date", function(value, fullDate = false) {
    //  ["Mon", "Jan", "25", "2021", "21:29:24", "GMT+0100", "(UTC+01:00)"]
    if (value) {
        const date = new Date(Date.parse(value)).toString().split(" ");
        const currntDate = new Date().toString().split(" ");
        let result = "";
        if (date[2] == currntDate[2]) result = date[4].slice(0, 5); // get Time
        if (date[2] !== currntDate[2])
            result = date[2] + " " + date[1] + " at " + date[4].slice(0, 5); // get Day and Month
        if (date[3] !== currntDate[3])
            result = date[2] + " " + date[1] + " " + date[3] + " at " + date[4].slice(0, 5); // get Year
        return result;
    }
});

Vue.filter("month", function(val, showYear = true) {
    val = String(val);

    const regx = /\w+\s(\w+)\s\d+\s(\d+)./;
    if (!showYear) {
        return regx.exec(val)[1];
    } else {
        return regx.exec(val)[1] + " " + regx.exec(val)[2];
    }
});

Vue.filter("csv", function(value) {
    return value.join(", ");
});

Vue.filter("filter_tags", function(value) {
    return value.replace(/<\/?[^>]+(>|$)/g, "");
});

Vue.filter("k_formatter", function(num) {
    if (num > 999 && num < 999999)
        if (num > 1099) return (num / 1000).toFixed(1) + "K";
        else return num / 1000 + "K"; // 1K
    if (num > 999999)
        if (num > 1099999) return (num / 1000000).toFixed(1) + "M";
        else return num / 1000000 + "M";
    // 1M
    else return num;
});
