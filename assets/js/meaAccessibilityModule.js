jQuery(document).ready(function(e) {
        !(function(e) {
            e.fn.meaCodesAccessibilityModule = function(a, t, c, i, n) {
                const o = e(this);

                function s() {
                    e(".meaAccessibility_fieldTriger", o).each(function() {
                        const a = e(this).parent();
                        a.hasClass("meaAccessibility_fieldActive") && a.removeClass("meaAccessibility_fieldActive");
                    });
                }
                o.on("keydown", function(e) {
                        27 === e.keyCode && o.hasClass("meaAccessibility_widgetOpen") && (o.removeClass("meaAccessibility_widgetOpen"), o.css("display", "none"), "custom" === n && o.addClass("meaAccessibility_widgetHidden"));
                    }),
                    e(".meaAccessibility_propertiesToggle", o).click(function() {
                        o.toggleClass("meaAccessibility_widgetOpen"), "custom" === n && (o.hasClass("meaAccessibility_widgetOpen") ? o.removeClass("meaAccessibility_widgetHidden") : o.addClass("meaAccessibility_widgetHidden"));
                    }),
                    e(".meaAccessibility_closeWidget", o).click(function() {
                        o.removeClass("meaAccessibility_widgetOpen");
                        o.css("display", "none");
                        "custom" === n && o.addClass("meaAccessibility_widgetHidden");
                    }),
                    e(".openmeaAcccessibilityWidget").click(function() {
                        return o.toggleClass("meaAccessibility_widgetOpen"), "custom" === n && (o.hasClass("meaAccessibility_widgetOpen") ? o.removeClass("meaAccessibility_widgetHidden") : o.addClass("meaAccessibility_widgetHidden")), !1;
                    });
                    
                    // Handle external button click
                    e("#meaAccessibility_externalToggle").click(function() {
                        if (o.hasClass("meaAccessibility_widgetOpen")) {
                            o.removeClass("meaAccessibility_widgetOpen");
                            o.css("display", "none");
                            "custom" === n && o.addClass("meaAccessibility_widgetHidden");
                        } else {
                            o.css("display", "block");
                            o.addClass("meaAccessibility_widgetOpen");
                            "custom" === n && o.removeClass("meaAccessibility_widgetHidden");
                        }
                        return false;
                    });
                var d = localStorage.getItem("meaAcM__fontSize");

                function l(a) {
                    a
                        ?
                        (e("body").addClass("meaAccessibility_grayscaleImg"),
                            e("div, section, span, a").each(function() {
                                "none" !== e(this).css("background-image") && e(this).css("filter", "grayscale(100%)");
                            })) :
                        (e("body").removeClass("meaAccessibility_grayscaleImg"),
                            e("div, section, span, a").each(function() {
                                "none" !== e(this).css("background-image") && e(this).css("filter", "initial");
                            }));
                }

                function m(a) {
                    a ? e("body").addClass("meaAccessibility_blackAndWhite") : e("body").removeClass("meaAccessibility_blackAndWhite");
                }
                d && (e(".meaAcM__fontSize input[value='" + d + "']").prop("checked", !0), e("body").removeClass("meaAccessibility_fontSizeS meaAccessibility_fontSizeNormal meaAccessibility_fontSizeL meaAccessibility_fontSizeXL meaAccessibility_fontSizeXXL").addClass(d)),
                    e(".meaAcM__fontSize input[type=radio]").change(function() {
                        var a = e(this).val();
                        e("body").removeClass("meaAccessibility_fontSizeS meaAccessibility_fontSizeNormal meaAccessibility_fontSizeL meaAccessibility_fontSizeXL meaAccessibility_fontSizeXXL").addClass(a),
                            (function(e) {
                                localStorage.setItem("meaAcM__fontSize", e);
                            })(a);
                    }),
                    e(document).ready(function() {
                        var a = localStorage.getItem("meaAcM__lineSpacing");
                        a && (e(".meaAcM__lineSpacing input[value='" + a + "']").prop("checked", !0), e("body").removeClass("meaAccessibility_LineHeightNormal meaAccessibility_lineHeight1 meaAccessibility_lineHeight2").addClass(a));
                    }),
                    e(".meaAcM__lineSpacing input[type=radio]").change(function() {
                        var a = e(this).val();
                        e("body").removeClass("meaAccessibility_LineHeightNormal meaAccessibility_lineHeight1 meaAccessibility_lineHeight2").addClass(a),
                            (function(e) {
                                localStorage.setItem("meaAcM__lineSpacing", e);
                            })(a);
                    }),
                    e(document).ready(function() {
                        var a = localStorage.getItem("meaAcM__letterSpacing");
                        a && (e(".meaAcM__letterSpacing input[value='" + a + "']").prop("checked", !0), e("body").removeClass("meaAccessibility_letterSpacingNormal meaAccessibility_letterSpacing1 meaAccessibility_letterSpacing2").addClass(a));
                    }),
                    e(".meaAcM__letterSpacing input[type=radio]").change(function() {
                        var a = e(this).val();
                        e("body").removeClass("meaAccessibility_letterSpacingNormal meaAccessibility_letterSpacing1 meaAccessibility_letterSpacing2").addClass(a),
                            (function(e) {
                                localStorage.setItem("meaAcM__letterSpacing", e);
                            })(a);
                    }),
                    e(document).ready(function() {
                        "true" === localStorage.getItem("meaAcM__dyslexieFont") &&
                            (e(".meaAcM__dyslexieFont").prop("checked", !0),
                                e(".top-adhd-box").remove(),
                                e(".bottom-adhd-box").remove(),
                                e("body").append("<div class='top-adhd-box'><div class='top-inner-adhd-box'></div></div><div class='bottom-adhd-box'><div class='bottom-inner-adhd-box'></div></div>"));
                    }),
                    e(".meaAcM__dyslexieFont").change(function() {
                        const n = e(this).prop("checked");
                        // Remove existing elements first to prevent duplicates
                        e(".top-adhd-box").remove();
                        e(".bottom-adhd-box").remove();
                        if (n) {
                            // Create new elements
                            var topBox = e("<div class='top-adhd-box'><div class='top-inner-adhd-box'></div></div>");
                            var bottomBox = e("<div class='bottom-adhd-box'><div class='bottom-inner-adhd-box'></div></div>");
                            e("body").append(topBox).append(bottomBox);
                        }
                        "session" === a ?
                            sendSessionAjax(t, c, i, "DyslexieFont", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__dyslexieFont", e);
                            })(n.toString());
                    }),
                    e(document).ready(function() {
                        "true" === localStorage.getItem("meaAcM__grayscale") && (e(".meaAcM__grayscale").prop("checked", !0), e("html").addClass("meaAccessibility_grayscale"));
                    }),
                    e(".meaAcM__grayscale").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            n ? e("html").addClass("meaAccessibility_grayscale") : e("html").removeClass("meaAccessibility_grayscale"),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "Grayscale", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__grayscale", e.toString());
                            })(n);
                        
                        // Create or remove filter overlay for grayscale effect
                        if (n) {
                            var filterOverlay = document.getElementById('meaAccessibility-filter-overlay');
                            if (!filterOverlay) {
                                filterOverlay = document.createElement('div');
                                filterOverlay.id = 'meaAccessibility-filter-overlay';
                                filterOverlay.className = 'meaAccessibility-filter-overlay';
                                document.body.appendChild(filterOverlay);
                            }
                        } else {
                            var filterOverlay = document.getElementById('meaAccessibility-filter-overlay');
                            if (filterOverlay) {
                                filterOverlay.remove();
                            }
                        }
                    }),
                    e(document).ready(function() {
                        "true" === localStorage.getItem("meaAcM__contrast") && (e(".meaAcM__contrast").prop("checked", !0), e("html").addClass("meaAccessibility_contrast"));
                    }),
                    e(".meaAcM__contrast").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            n ? e("html").addClass("meaAccessibility_contrast") : e("html").removeClass("meaAccessibility_contrast"),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "Contrast", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__contrast", e.toString());
                            })(n);
                        
                        // Create or remove filter overlay for contrast effect
                        if (n) {
                            var filterOverlay = document.getElementById('meaAccessibility-filter-overlay');
                            if (!filterOverlay) {
                                filterOverlay = document.createElement('div');
                                filterOverlay.id = 'meaAccessibility-filter-overlay';
                                filterOverlay.className = 'meaAccessibility-filter-overlay';
                                document.body.appendChild(filterOverlay);
                            }
                        } else {
                            var filterOverlay = document.getElementById('meaAccessibility-filter-overlay');
                            if (filterOverlay) {
                                filterOverlay.remove();
                            }
                        }
                    }),
                    e(document).ready(function() {
                        "true" === localStorage.getItem("meaAcM__negativ") && (e(".meaAcM__negativ").prop("checked", !0), e("html").addClass("meaAccessibility_negativ"));
                    }),
                    e(".meaAcM__negativ").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            n ? e("html").addClass("meaAccessibility_negativ") : e("html").removeClass("meaAccessibility_negativ"),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "Negativ", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__negativ", e.toString());
                            })(n);
                        
                        // Create or remove filter overlay for negative effect - same as modern-theme.php
                        if (n) {
                            var filterOverlay = document.getElementById('meacodes-filter-overlay');
                            if (!filterOverlay) {
                                filterOverlay = document.createElement('div');
                                filterOverlay.id = 'meacodes-filter-overlay';
                                filterOverlay.className = 'meacodes-filter-overlay';
                                document.body.appendChild(filterOverlay);
                            }
                            // Add the class to body like modern-theme.php
                            document.body.classList.add('meacodes-invert-colors');
                        } else {
                            var filterOverlay = document.getElementById('meacodes-filter-overlay');
                            if (filterOverlay) {
                                filterOverlay.remove();
                            }
                            // Remove the class from body like modern-theme.php
                            document.body.classList.remove('meacodes-invert-colors');
                        }
                    }),
                    e(document).ready(function() {
                        "true" === localStorage.getItem("meaAcM__underlinedLinks") && (e(".meaAcM__underlinedLinks").prop("checked", !0), e("body").addClass("meaAccessibility_aUnderlined"));
                    }),
                    e(".meaAcM__underlinedLinks").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            n ? e("body").addClass("meaAccessibility_aUnderlined") : e("body").removeClass("meaAccessibility_aUnderlined"),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "UnderlinedLinks", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__underlinedLinks", e.toString());
                            })(n);
                    }),
                    e(document).ready(function() {
                        "true" === localStorage.getItem("meaAcM__highlightLinks") && (e(".meaAcM__highlightLinks").prop("checked", !0), e("body").addClass("meaAccessibility_aHighlight"));
                    }),
                    e(".meaAcM__highlightLinks").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            n ? e("body").addClass("meaAccessibility_aHighlight") : e("body").removeClass("meaAccessibility_aHighlight"),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "HighlightLinks", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__highlightLinks", e.toString());
                            })(n);
                    }),
                    e(window).on("load", function() {
                        "true" === localStorage.getItem("meaAcM__grayscaleImages") && (e(".meaAcM__grayscaleImages").prop("checked", !0), l(!0));
                    }),
                    e(".meaAcM__grayscaleImages").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            l(n),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "GrayscaleImages", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__grayscaleImages", e.toString());
                            })(n);
                    }),
                    e(window).on("load", function() {
                        "true" === localStorage.getItem("meaAcM__blackAndWhite") && (e(".meaAcM__blackAndWhite").prop("checked", !0), m(!0));
                    }),
                    e(".meaAcM__blackAndWhite").change(function() {
                        var n = e(this).prop("checked");
                        s(),
                            m(n),
                            "session" === a ?
                            sendSessionAjax(t, c, i, "BlackAndWhite", n.toString()) :
                            (function(e) {
                                localStorage.setItem("meaAcM__blackAndWhite", e.toString());
                            })(n);
                    }),
                    e(".meaAccessibility_fieldTriger", o).on("click", function() {
                        var a = e(this).parent(),
                            t = a.hasClass("meaAccessibility_fieldActive");
                        e(".meaAccessibility_fieldTriger", o).each(function(t) {
                                a != e(this).parent() && e(this).parent().removeClass("meaAccessibility_fieldActive");
                            }),
                            t ? a.removeClass("meaAccessibility_fieldActive") : a.addClass("meaAccessibility_fieldActive");
                    }),
                    e(".meaAccessibility_resetChanges", o).click(function() {
                        e("body").removeClass(
                                "meaAccessibility_fontSizeS meaAccessibility_fontSizeL meaAccessibility_fontSizeXL meaAccessibility_fontSizeXXL meaAccessibility_dyslexic meaAccessibility_grayscale meaAccessibility_contrast meaAccessibility_negativ meaAccessibility_aUnderlined meaAccessibility_aHighlight meaAccessibility_grayscaleImg meaAccessibility_letterSpacing1 meaAccessibility_letterSpacing2 meaAccessibility_lineHeight1 meaAccessibility_lineHeight2 meaAccessibility_blackAndWhite"
                            ),
                            e("html").removeClass("meaAccessibility_grayscale meaAccessibility_contrast meaAccessibility_negativ"),
                            e("div").each(function() {
                                "grayscale(1)" == e(this).css("filter") && e(this).css("filter", "initial");
                            }),
                            e("section").each(function() {
                                "grayscale(1)" == e(this).css("filter") && e(this).css("filter", "initial");
                            }),
                            e("span").each(function() {
                                "grayscale(1)" == e(this).css("filter") && e(this).css("filter", "initial");
                            }),
                            e("a").each(function() {
                                "grayscale(1)" == e(this).css("filter") && e(this).css("filter", "initial");
                            }),
                            e(".meaAcM__fontSize", o).find("input[value='meaAccessibility_fontSizeNormal']").prop("checked", !0),
                            e(".meaAcM__lineSpacing", o).find("input[value='meaAccessibility_LineHeightNormal']").prop("checked", !0),
                            e(".meaAcM__letterSpacing", o).find("input[value='meaAccessibility_letterSpacingNormal']").prop("checked", !0),
                            e(".meaAcM__dyslexieFont", o).prop("checked", !1),
                            e(".top-adhd-box").remove(),
                            e(".bottom-adhd-box").remove(),
                            e(".meaAcM__grayscale", o).prop("checked", !1),
                            e(".meaAcM__contrast", o).prop("checked", !1),
                            e(".meaAcM__negativ", o).prop("checked", !1),
                            e(".meaAcM__underlinedLinks", o).prop("checked", !1),
                            e(".meaAcM__highlightLinks", o).prop("checked", !1),
                            e(".meaAcM__grayscaleImages", o).prop("checked", !1),
                            e(".meaAcM__blackAndWhite", o).prop("checked", !1),
                            eraseCookie("meaAcM__fontSize"),
                            eraseCookie("meaAcM__lineSpacing"),
                            eraseCookie("meaAcM__letterSpacing"),
                            eraseCookie("meaAcM__dyslexieFont"),
                            eraseCookie("meaAcM__grayscale"),
                            eraseCookie("meaAcM__contrast"),
                            eraseCookie("meaAcM__negativ"),
                            eraseCookie("meaAcM__underlinedLinks"),
                            eraseCookie("meaAcM__highlightLinks"),
                            eraseCookie("meaAcM__grayscaleImages"),
                            eraseCookie("meaAcM__blackAndWhite"),
                            "session" == a && sendSessionAjax(t, c, i, "eraseall", "data"),
                            s(),
                            localStorage.clear(),
                            location.reload();
                    });
            };
        })(e),
        e(document).ready(function() {
            window.innerHeight;
            var a = meaParams.selectedPosition;
            e(".meaCodesAccessibilityModule").removeClass("meaAccessibility_widgetBottomLeft meaAccessibility_widgetBottomRight meaAccessibility_widgetTopLeft meaAccessibility_widgetTopRight").addClass(a),
                e(".meaCodesAccessibilityModule").hide(), // Start hidden
                "function" == typeof e.fn.meaCodesAccessibilityModule &&
                e(".openmeaAcccessibilityWidget").on("click", function() {
                    e(".meaCodesAccessibilityModule").meaCodesAccessibilityModule("cookie", "0", "477", "4103"), e(".meaCodesAccessibilityModule").addClass("meaAccessibility_widgetOpen");
                });
        });
    }),
    jQuery(document).ready(function(e) {
        var a = e(".meaAccessibility_propertiesToggle");
        a.length &&
            (e(".meaAccessibility_accessibility-text").hide(),
                e(".meaAccessibility_GDPR_btn").hide(),
                a.click(function() {
                    e(".meaAccessibility_accessibility-text").toggle(), e(".meaAccessibility_GDPR_btn").toggle(), e(".meaAccessibility_properties").removeClass("fade-in"), e(".meaAccessibility_properties")[0].offsetWidth, e(".meaAccessibility_properties").addClass("fade-in");
                }),
                e(".meaAccessibility_closeWidget").click(function() {
                    e(".meaAccessibility_accessibility-text").hide(), e(".meaAccessibility_GDPR_btn").hide(), e(".meaAccessibility_properties").removeClass("fade-in");
                }));
    }),
    document.addEventListener("DOMContentLoaded", function() {
        // Check if gdprNoticeLink element exists before adding event listeners
        const gdprNoticeLink = document.getElementById("gdprNoticeLink");
        const gdprNoticeModal = document.getElementById("gdprNoticeModal");
        const closeModalButton = document.querySelector(".meaAccessibility_close");
        const modalContent = document.querySelector(".meaAccessibility_modal-content");
    
        if (gdprNoticeLink && gdprNoticeModal && closeModalButton && modalContent) {
            // Open modal and add 'active' class to gdprNoticeLink
            gdprNoticeLink.addEventListener("click", function() {
                gdprNoticeModal.style.display = "block";
                gdprNoticeLink.classList.add("active");
            });
    
            // Close modal and remove 'active' class from gdprNoticeLink
            closeModalButton.addEventListener("click", function() {
                gdprNoticeModal.style.display = "none";
                gdprNoticeLink.classList.remove("active");
            });
    
            // Close modal if clicking outside modal content
            gdprNoticeModal.addEventListener("click", function() {
                gdprNoticeModal.style.display = "none";
                gdprNoticeLink.classList.remove("active");
            });
    
            // Prevent click events inside modal content from closing modal
            modalContent.addEventListener("click", function(e) {
                e.stopPropagation();
            });
        }
    }),    
    jQuery(document).ready(function(e) {
        e(document).on("mousemove", function(a) {
            var t = a.clientY;
            e(".top-adhd-box").css("height", t - 50), e(".bottom-adhd-box").css("height", e(window).height() - t - 50);
        });
    });