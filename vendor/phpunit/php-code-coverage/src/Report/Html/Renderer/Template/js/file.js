  /*
 * +---------------------------------------------------------------------+
 * | This file is part of chem-inventory.                                |
 * |                                                                     |
 * | Copyright (c) 2020 Sandor Semsey                                    |
 * | All rights reserved.                                                |
 * |                                                                     |
 * | This work is published under the MIT License.                       |
 * | https://choosealicense.com/licenses/mit/                            |
 * |                                                                     |
 * | It's a free software;)                                              |
 * |                                                                     |
 * | THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,     |
 * | EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES     |
 * | OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND            |
 * | NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS |
 * | BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN  |
 * | ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN   |
 * | CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE    |
 * | SOFTWARE.                                                           |
 * +---------------------------------------------------------------------+
 */

$(function() {
   var $window     = $(window)
     , $top_link   = $('#toplink')
     , $body       = $('body, html')
     , offset      = $('#code').offset().top
     , hidePopover = function ($target) {
        $target.data('popover-hover', false);

        setTimeout(function () {
         if (!$target.data('popover-hover')) {
          $target.popover('hide');
         }
        }, 300);
     };

   $top_link.hide().click(function(event) {
    event.preventDefault();
    $body.animate({scrollTop:0}, 800);
   });

   $window.scroll(function() {
    if($window.scrollTop() > offset) {
     $top_link.fadeIn();
    } else {
     $top_link.fadeOut();
    }
   }).scroll();

   $('.popin')
    .popover({trigger: 'manual'})
    .on({
     'mouseenter.popover': function () {
      var $target = $(this);
      var $container = $target.children().first();

      $target.data('popover-hover', true);

      // popover already displayed
      if ($target.next('.popover').length) {
       return;
      }

      // show the popover
      $container.popover('show');

      // register mouse events on the popover
      $target.next('.popover:not(.popover-initialized)')
       .on({
        'mouseenter': function () {
         $target.data('popover-hover', true);
        },
        'mouseleave': function () {
         hidePopover($container);
        }
       })
       .addClass('popover-initialized');
     },
     'mouseleave.popover': function () {
      hidePopover($(this).children().first());
     }
    });
  });
