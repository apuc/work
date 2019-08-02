
var mobileMinWidth = 8000;
var mobileTableId = 1;

$('.calculator h3').click(function () {
    $('.mobile-calculator').slideToggle(500);
});

$(window).resize(function() {
    $('#wrapper').width($(window).width() - 1);
});
setTimeout(function () { $(window).trigger('resize') }, 300);

$('.sidebar-toggle').unbind('click');
$('.sidebar-toggle').click(function(e) {
    if ($(window).width() <= mobileMinWidth) {
        var has = $('body').hasClass('sidebar-collapse');
        if (has) {
            var width = $('.content-page').width();
            $('.content-page').width(width + 'px');
            $('body').toggleClass("sidebar-collapse");
        } else {
            $('body').toggleClass("sidebar-collapse");
            setTimeout(function () { $('.content-page').width('auto'); }, 500);
        }
    } else {
        $('body').toggleClass("sidebar-collapse");
    }
    e.preventDefault();
});

$(document).ready(function () {
    $(".mobile-table").each(function () {
        $(this).prop("data-table", mobileTableId++);
        $(this).mobileTable('init');
    })
});

$(document).on('pjax:success', function() {
    $(".mobile-table").each(function () {
        $(this).mobileTable('reinit');
    })
});

$.fn.extend({
    mobileTable: function (method)
    {
        var $this = this;
        var $control = this.find('.mobile-table-control');
        var name = $this.prop('data-table');
        var width = $(window).width();
                
        this.init = function ()
        {
            this.control();
            if ($(window).width() <= mobileMinWidth) {
                setTimeout(function () { $this.business(); }, 300);
            }
            $(window).resize(function () {
                $this.resize();
            });
            this.events();
        }
        
        this.reinit = function()
        {
            this.control();
            if ($(window).width() <= mobileMinWidth) {
                setTimeout(function () { $this.business(); }, 300);
            }
            this.resize();
            this.events();
        }
        
        this.events = function()
        {
             $control.find('input').change(function () {
                var i = $(this).attr('id').match(/\d+$/)[0];
                if ($(this).is(":checked")) {
                    $this.show(i);
                } else {
                    $this.hide(i);
                }
                $this.saveState();
            });
            
            $control.find('.mobile-control-title').click(function () {
                if ($control.find('.mobile-table-column-list').is(':visible')) {
                    $(this).find('span').text('Показать');
                    $control.find('.mobile-table-column-list').hide(0);
                } else {
                    $(this).find('span').text('Скрыть');
                    $control.find('.mobile-table-column-list').show(0);
                }
            });
        }
        
        this.resize = function ()
        {
            if (width != $(window).width()) {
                if ($(window).width() <= mobileMinWidth) {
                    $this.find('th,td').show();
                    $control.find('input').prop('checked', true);
                    setTimeout(function () { $this.business(); }, 300);
                } else {
                    setTimeout(function () { $this.find('th,td').show();}, 400);
                }
                width = $(window).width();
             }
        }
        
        this.control = function ()
        {
            $control.html('');
            let li = [];
            this.find('table:first th').each(function (i) {
                li.push('<li class="clearfix">' +
                `<span><input checked id="${name}-th-${i}" type="checkbox"></span>` + 
                `<span><label for="${name}-th-${i}">` + $(this).text() + '</label></span>' + 
                '</li>');
            });
            $control.append("<ul class='mobile-table-column-list' style='display:none'>" + li.join("") + "</ul>");
            $control.append('<div class="mobile-control-title"><span>Показать</span></div>');
        }
        
        this.business = function ()
        {
            var state = this.getState();
            var length = this.find('th').length;
            
            if (state) {
                for (let i = length - 1; i >= 0; i--) {
                    if (state.indexOf(i.toString()) < 0) {
                        $this.hide(i)
                        $control.find('input').eq(i).prop('checked', false);
                    }
                }
            } else {
                for (let i = length - 2; i >= 0; i--) {
                    $this.hide(i);
                    $control.find('input').eq(i).prop('checked', false);
                    if (!this.hasScroll()) break;
                }
                this.saveState();
            }   
        }
        
        this.hide = function (i)
        {
            this.find('tr').each(function () {
                $(this).find('th,td').eq(i).hide();
            });
        }
        
        this.show = function (i)
        {
            this.find('tr').each(function () {
                $(this).find('th,td').eq(i).show();
            });
        }
        
        this.hasScroll = function ()
        {
            var $tab = this.closest('.tab-pane');
            var active = $tab.hasClass('active');
            $tab.addClass('active');
            var width = this.get(0).scrollWidth > this.width() + 1;
            if (!active) $tab.removeClass('active');
            return width;
        }
        
        this.getState = function ()
        {
            if ($.cookie(this.prop('class'))) {
                return JSON.parse($.cookie(this.prop('class')));
            } else {
                return null;
            }
        }
        
        this.saveState = function ()
        {
            var indexes = [];
            
            $control.find('input:checked').each(function () {
                var i = $(this).attr('id').match(/\d+$/)[0];
                indexes.push(i)
            });

            $.cookie(this.prop('class'), JSON.stringify(indexes), {expires: 180});
        }
        
        if (typeof(method) == 'undefined' || method == 'init') {
            this.init();
        } else if (method == 'reinit') {
            this.reinit();
        }
    }
});