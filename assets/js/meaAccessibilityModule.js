jQuery(function($) {
    // Accessibility Module Function
    $.fn.meaCodesAccessibilityModule = function(a, t, c, i, n) {
        const $widget = $(this);

        function toggleFieldActive() {
            $(".meaAccessibility_fieldTriger", $widget).each(function() {
                const $parent = $(this).parent();
                if ($parent.hasClass("meaAccessibility_fieldActive")) {
                    $parent.removeClass("meaAccessibility_fieldActive");
                }
            });
        }

        function applyAccessibilitySettings() {
            const settings = [
                'fontSize',
                'lineSpacing',
                'letterSpacing',
                'dyslexieFont',
                'grayscale',
                'contrast',
                'negativ',
                'underlinedLinks',
                'highlightLinks',
                'grayscaleImages',
                'blackAndWhite'
            ];

            settings.forEach(setting => {
                const value = localStorage.getItem(`meaAcM__${setting}`);
                if (value) {
                    $(`.meaAcM__${setting} input[value='${value}']`).prop('checked', true);
                    $('body').removeClass(`meaAccessibility_${setting}Normal meaAccessibility_${setting}1 meaAccessibility_${setting}2`).addClass(value);
                }
            });
        }

        function setCookie(key, value) {
            localStorage.setItem(key, value);
        }

        function clearCookie(key) {
            localStorage.removeItem(key);
        }

        function resetAccessibility() {
            const classesToRemove = [
                "meaAccessibility_fontSizeS", "meaAccessibility_fontSizeL", "meaAccessibility_fontSizeXL", "meaAccessibility_fontSizeXXL",
                "meaAccessibility_dyslexic", "meaAccessibility_grayscale", "meaAccessibility_contrast", "meaAccessibility_negativ",
                "meaAccessibility_aUnderlined", "meaAccessibility_aHighlight", "meaAccessibility_grayscaleImg", "meaAccessibility_letterSpacing1",
                "meaAccessibility_letterSpacing2", "meaAccessibility_lineHeight1", "meaAccessibility_lineHeight2", "meaAccessibility_blackAndWhite"
            ];

            $('body').removeClass(classesToRemove.join(' '));
            $('html').removeClass("meaAccessibility_grayscale meaAccessibility_contrast meaAccessibility_negativ");

            $(".top-adhd-box, .bottom-adhd-box").remove();
            $(".meaAcM__fontSize input[value='meaAccessibility_fontSizeNormal']").prop('checked', true);
            $(".meaAcM__lineSpacing input[value='meaAccessibility_LineHeightNormal']").prop('checked', true);
            $(".meaAcM__letterSpacing input[value='meaAccessibility_letterSpacingNormal']").prop('checked', true);
            $(".meaAcM__dyslexieFont").prop('checked', false);
            $(".meaAcM__grayscale, .meaAcM__contrast, .meaAcM__negativ, .meaAcM__underlinedLinks, .meaAcM__highlightLinks, .meaAcM__grayscaleImages, .meaAcM__blackAndWhite").prop('checked', false);

            clearCookie("meaAcM__fontSize");
            clearCookie("meaAcM__lineSpacing");
            clearCookie("meaAcM__letterSpacing");
            clearCookie("meaAcM__dyslexieFont");
            clearCookie("meaAcM__grayscale");
            clearCookie("meaAcM__contrast");
            clearCookie("meaAcM__negativ");
            clearCookie("meaAcM__underlinedLinks");
            clearCookie("meaAcM__highlightLinks");
            clearCookie("meaAcM__grayscaleImages");
            clearCookie("meaAcM__blackAndWhite");

            localStorage.clear();
            location.reload();
        }

        function handleWidgetEvents() {
            $widget.on("keydown", function(e) {
                if (e.keyCode === 27 && $widget.hasClass("meaAccessibility_widgetOpen")) {
                    $widget.removeClass("meaAccessibility_widgetOpen");
                    if (n === "custom") $widget.addClass("meaAccessibility_widgetHidden");
                }
            });

            $(".meaAccessibility_propertiesToggle", $widget).click(function() {
                $widget.toggleClass("meaAccessibility_widgetOpen");
                if (n === "custom") {
                    $widget.toggleClass("meaAccessibility_widgetHidden", !$widget.hasClass("meaAccessibility_widgetOpen"));
                }
            });

            $(".meaAccessibility_closeWidget", $widget).click(function() {
                $widget.removeClass("meaAccessibility_widgetOpen");
                if (n === "custom") $widget.addClass("meaAccessibility_widgetHidden");
            });

            $(".openmeaAcccessibilityWidget").click(function() {
                $widget.toggleClass("meaAccessibility_widgetOpen");
                if (n === "custom") {
                    $widget.toggleClass("meaAccessibility_widgetHidden", !$widget.hasClass("meaAccessibility_widgetOpen"));
                }
                return false;
            });

            $(".meaAccessibility_fieldTriger", $widget).click(function() {
                const $parent = $(this).parent();
                const isActive = $parent.hasClass("meaAccessibility_fieldActive");

                $(".meaAccessibility_fieldTriger", $widget).each(function() {
                    if ($parent[0] !== $(this).parent()[0]) {
                        $(this).parent().removeClass("meaAccessibility_fieldActive");
                    }
                });

                $parent.toggleClass("meaAccessibility_fieldActive", !isActive);
            });

            $(".meaAccessibility_resetChanges", $widget).click(resetAccessibility);
        }

        function handleSettings() {
            const settings = [
                'fontSize', 'lineSpacing', 'letterSpacing', 'dyslexieFont', 'grayscale', 'contrast', 'negativ',
                'underlinedLinks', 'highlightLinks', 'grayscaleImages', 'blackAndWhite'
            ];

            settings.forEach(setting => {
                $(`.meaAcM__${setting} input[type=radio]`).change(function() {
                    const value = $(this).val();
                    $('body').removeClass(`meaAccessibility_${setting}Normal meaAccessibility_${setting}1 meaAccessibility_${setting}2`).addClass(value);
                    setCookie(`meaAcM__${setting}`, value);
                });
            });
        }

        function handleGrayscaleImages() {
            $(window).on("load", function() {
                if (localStorage.getItem("meaAcM__grayscaleImages") === "true") {
                    $(".meaAcM__grayscaleImages").prop("checked", true);
                    toggleGrayscaleImages(true);
                }
            });

            $(".meaAcM__grayscaleImages").change(function() {
                const isChecked = $(this).prop("checked");
                toggleGrayscaleImages(isChecked);
                setCookie("meaAcM__grayscaleImages", isChecked.toString());
            });
        }

        function toggleGrayscaleImages(enable) {
            $("html").toggleClass("meaAccessibility_grayscale", enable);
        }

        // Initialize Accessibility Module
        $(document).ready(function() {
            applyAccessibilitySettings();
            handleWidgetEvents();
            handleSettings();
            handleGrayscaleImages();
        });

        $(window).on("load", function() {
            $(".meaCodesAccessibilityModule").removeClass("meaAccessibility_widgetBottomLeft meaAccessibility_widgetBottomRight meaAccessibility_widgetTopLeft meaAccessibility_widgetTopRight").addClass(meaParams.selectedPosition);
            $(".meaCodesAccessibilityModule").show();
            if (typeof $.fn.meaCodesAccessibilityModule === 'function') {
                $(".openmeaAcccessibilityWidget").on("click", function() {
                    $(".meaCodesAccessibilityModule").meaCodesAccessibilityModule("cookie", "0", "477", "4103");
                    $(".meaCodesAccessibilityModule").addClass("meaAccessibility_widgetOpen");
                });
            }
        });
    };

    // GDPR Modal Handling
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("gdprNoticeLink").addEventListener("click", function() {
            document.getElementById("gdprNoticeModal").style.display = "block";
            document.getElementById("gdprNoticeLink").classList.add("active");
        });

        document.querySelector(".meaAccessibility_close").addEventListener("click", function() {
            document.getElementById("gdprNoticeModal").style.display = "none";
            document.getElementById("gdprNoticeLink").classList.remove("active");
        });

        document.getElementById("gdprNoticeModal").addEventListener("click", function() {
            document.getElementById("gdprNoticeModal").style.display = "none";
            document.getElementById("gdprNoticeLink").classList.remove("active");
        });

        document.querySelector(".meaAccessibility_modal-content").addEventListener("click", function(e) {
            e.stopPropagation();
        });
    });

    // ADHD Box Resizing
    $(document).on("mousemove", function(e) {
        const clientY = e.clientY;
        $(".top-adhd-box").css("height", clientY - 50);
        $(".bottom-adhd-box").css("height", $(window).height() - clientY - 50);
    });
});