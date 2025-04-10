import './bootstrap';
Echo.private('App.Models.dashboard.Admin.' + admin_id)
    .notification((event) => {
        $('.notification-dropdown').append(`
            <a  href="${event.url}">
                <div class="media">
                    <div class="media-left align-self-center">
                        <i class="ft-bell icon-bg-circle bg-cyan"></i>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">
                            طلب جديد
                            <span>
                                    ${event.title}
                                رقم
                                الطلب :
                                ${event.order_id}
                            </span>
                        </h6>
                    </div>
                </div>
            </a>
    `);
        var unreadnotification = parseInt($('#unread').text());
        $('#unread').text(unreadnotification + 1);
        // تشغيل صوت الإشعار
        notificationSound.play();
    });
