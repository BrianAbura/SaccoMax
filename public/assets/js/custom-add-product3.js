(function () {
    // Snow editor
    var editor5 = new Quill("#editor5", {
        modules: { toolbar: "#toolbar5" },
        theme: "snow",
        placeholder: "Enter your messages...",
    });

    // Bubble editor
    var editor6 = new Quill("#editor6", {
        modules: { toolbar: "#toolbar6" },
        theme: "bubble",
        placeholder: "Enter your messages...",
    });

    // Standard editor
    var editor7 = new Quill("#editor7", {
        modules: { toolbar: "#toolbar7" },
        theme: "snow",
        placeholder: "Enter your messages...",
    });

    // Handle form submission
    document.getElementById("messagesForm").onsubmit = function () {
        var htmlContent = editor7.root.innerHTML;

        document.getElementById("message_body").value = htmlContent;
    };
})();
