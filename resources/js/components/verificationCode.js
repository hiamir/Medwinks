document.addEventListener('alpine:init', function () {
    Alpine.data('Verification', (data) => ({
        validateKeys: [],
        verificationCode: data.verificationCode,
        isCodeMatched: data.isCodeMatched,
        verificationCodeLength: data.verificationCodeLength,
        isCodeExpired: data.isCodeExpired,
        expiringAt: data.expiringAt,
        msg: data.msg,

        init() {
            this.validateKeys = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
            this.resetVerificationCode();
            Alpine.effect(() => {
                console.log(this.msg);
            });

        },
        msgReset() {
            if (this.msg['type'] !== '') this.msg['type'] = '';
            if (this.msg['action'] !== '') this.msg['action'] = '';
            if (this.msg['message'] !== '') this.msg['message'] = '';
        },

        msgExpired() {
            this.msg['type'] = 'error';
            this.msg['action'] = 'expired';
            this.msg['message'] = 'Your Two Factor Code expired!';
        },

        resetVerificationCode() {
            for (let i = 0; i < this.verificationCodeLength; i++) {
                this.verificationCode[i] = null;
            }
        },

    }))
});
