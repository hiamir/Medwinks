document.addEventListener('alpine:init', () => {
    Alpine.data('Timer', (data) => ({
        expiringAt: data.expiringAt,
        isCodeExpired: data.isCodeExpired,
        isCodeMatched: data.isCodeMatched,
        oldExpiryAt: '',
        remaining: 0,
        intervalTimer: '',


        init() {
            this.setTimer(this.expiringAt)
            Alpine.effect(() => {
                this.setTimer(this.expiringAt);
            });
        },

        setRemaining() {
            const diff = Date.parse(this.expiringAt) - new Date().getTime();
            if (parseInt(diff / 1000) > 0) {
                this.remaining = parseInt(diff / 1000);
                this.isCodeExpired = false;
                // this.msgReset();
            } else {
// console.log(this.isCodeExpired);
                this.remaining = 0;
                if(this.isCodeExpired === false)this.msgExpired();
                this.isCodeExpired = true;

                // switch (this.msg.type){
                //     case 'error':
                //         console.log(this.msg.type);
                //         switch (this.msg.action){
                //             case 'expired':
                //                 if(this.msg.message === '')
                //                 break;
                //         }
                //         break;
                // }
                // if(this.msg.action)

                clearInterval(this.intervalTimer);
            }

        },

        setTimer(expiry) {
            this.setRemaining(expiry);
            if (this.isCodeExpired === false) {
                this.intervalTimer = setInterval(() => {
                    this.setRemaining(expiry);
                }, 1000);
            }
        },

        destroyTimerOnceDone() {
            console.log(this.remaining);
            if (this.remaining <= 0) {
                this.isCodeExpired = true;
                this.remaining = null;
                clearInterval(this.intervalTimer);
                console.log('killed!')
            }
        },

        days() {
            return {
                value: this.remaining / 86400,
                remaining: this.remaining % 86400
            };
        },

        hours() {
            return {
                value: this.days().remaining / 3600,
                remaining: this.days().remaining % 3600
            };
        },

        minutes() {
            return {
                value: this.hours().remaining / 60,
                remaining: this.hours().remaining % 60
            };
        },

        seconds() {
            return {
                value: this.minutes().remaining,
            };
        },

        format(value) {
            return ("0" + parseInt(value)).slice(-2)
        },

        time() {
            return {
                days: this.format(this.days().value),
                hours: this.format(this.hours().value),
                minutes: this.format(this.minutes().value),
                seconds: this.format(this.seconds().value),
            }
        },

    }))
})
