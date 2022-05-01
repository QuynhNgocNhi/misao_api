export const extendedRules = {
  phone: {
    validate(val) {
      return /^0\d{9,10}$/.test(val)
    },
    message: '{_field_}の形式が正しくありません。',
  },
  phoneRegionNumber: {
    validate(value) {
      if (value.includes('+')) {
        return /^[+]?[0-9]{3}[0-9]{3}[0-9]{4,6}$/g.test(value)
      }
      return /^[0-1]\d{9,10}$/g.test(value)
    },
    message: '{_field_}の形式が正しくありません。',
  },

  kana: {
    validate(val) {
      const rule = new RegExp('^[ァ-ヶー]+$')
      return rule.test(val)
    },
    message: '{_field_}はカタカナで入力してください。',
  },
}
