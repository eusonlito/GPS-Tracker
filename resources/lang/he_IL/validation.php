<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'יש לקבל את :attribute.',
    'accepted_if' => 'יש לקבל את :attribute כאשר :other הוא :value.',
    'active_url' => ':attribute אינו כתובת URL תקינה.',
    'after' => ':attribute חייב להיות תאריך אחרי :date.',
    'after_or_equal' => ':attribute חייב להיות תאריך אחרי או שווה ל-:date.',
    'alpha' => ':attribute יכול להכיל רק אותיות.',
    'alpha_dash' => ':attribute יכול להכיל רק אותיות, מספרים, מקפים ומקפים תחתונים.',
    'alpha_num' => ':attribute יכול להכיל רק אותיות ומספרים.',
    'array' => ':attribute חייב להיות מערך.',
    'before' => ':attribute חייב להיות תאריך לפני :date.',
    'before_or_equal' => ':attribute חייב להיות תאריך לפני או שווה ל-:date.',
    'between' => [
        'array' => ':attribute חייב להכיל בין :min ל-:max פריטים.',
        'file' => ':attribute חייב להיות בין :min ל-:max קילובייטים.',
        'numeric' => ':attribute חייב להיות בין :min ל-:max.',
        'string' => ':attribute חייב להיות בין :min ל-:max תווים.',
    ],
    'boolean' => 'שדה :attribute חייב להיות אמת או שקר.',
    'confirmed' => 'אימות :attribute אינו תואם.',
    'current_password' => 'הסיסמה שגויה.',
    'date' => ':attribute אינו תאריך תקין.',
    'date_equals' => ':attribute חייב להיות תאריך שווה ל-:date.',
    'date_format' => ':attribute אינו תואם לפורמט :format.',
    'declined' => 'חובה לדחות את :attribute.',
    'declined_if' => 'חובה לדחות את :attribute כאשר :other הוא :value.',
    'different' => ':attribute ו-:other חייבים להיות שונים.',
    'digits' => ':attribute חייב להיות בעל :digits ספרות.',
    'digits_between' => ':attribute חייב להיות בין :min ל-:max ספרות.',
    'dimensions' => ':attribute מימדי התמונה לא חוקיים.',
    'distinct' => 'שדה :attribute כופה ערך כפול.',
    'doesnt_end_with' => ':attribute אינו יכול להסתיים עם אחת מהערכים הבאים: :values.',
    'doesnt_start_with' => ':attribute אינו יכול להתחיל עם אחת מהערכים הבאים: :values.',
    'email' => ':attribute חייב להיות כתובת דוא"ל תקינה.',
    'ends_with' => ':attribute חייב להסתיים באחד מהערכים הבאים: :values.',
    'enum' => ':attribute שנבחר אינו תקף.',
    'exists' => ':attribute שנבחר אינו תקף.',
    'file' => ':attribute חייב להיות קובץ.',
    'filled' => 'חובה למלא את השדה :attribute.',
    'gt' => [
        'array' => 'ה-:attribute חייב לכלול יותר מ-:value פריטים.',
        'file' => 'ה-:attribute חייב להיות גדול מ-:value קילובייטים.',
        'numeric' => 'ה-:attribute חייב להיות גדול מ-:value.',
        'string' => 'ה-:attribute חייב להיות גדול מ-:value תווים.',
    ],
    'gte' => [
        'array' => 'שדה :attribute חייב לכלול :value פריטים או יותר.',
        'file' => 'שדה :attribute חייב להיות גדול מאו שווה ל-:value קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות גדול מאו שווה ל-:value.',
        'string' => 'שדה :attribute חייב להיות גדול מאו שווה ל-:value תווים.',
    ],
    'image' => 'שדה :attribute חייב להיות תמונה.',
    'in' => 'הערך שנבחר לשדה :attribute אינו תקין.',
    'in_array' => 'שדה :attribute לא קיים ב-:other.',
    'integer' => 'שדה :attribute חייב להיות מספר שלם.',
    'ip' => 'שדה :attribute חייב להיות כתובת IP תקינה.',
    'ipv4' => 'שדה :attribute חייב להיות כתובת IPv4 תקינה.',
    'ipv6' => 'שדה :attribute חייב להיות כתובת IPv6 תקינה.',
    'json' => 'שדה :attribute חייב להיות מחרוזת JSON תקינה.',
    'lt' => [
        'array' => 'שדה :attribute חייב לכלול פחות מ-:value פריטים.',
        'file' => 'שדה :attribute חייב להיות פחות מ-:value קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות פחות מ-:value.',
        'string' => 'שדה :attribute חייב להיות פחות מ-:value תווים.',
    ],
    'lte' => [
        'array' => 'שדה :attribute לא יכול לכלול יותר מ-:value פריטים.',
        'file' => 'שדה :attribute חייב להיות קטן או שווה ל-:value קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות קטן או שווה ל-:value.',
        'string' => 'שדה :attribute חייב להיות קטן או שווה ל-:value תווים.',
    ],
    'mac_address' => 'שדה :attribute חייב להיות כתובת MAC תקינה.',
    'max' => [
        'array' => 'שדה :attribute לא יכול לכלול יותר מ-:max פריטים.',
        'file' => 'שדה :attribute לא יכול להיות גדול מ-:max קילובייטים.',
        'numeric' => 'שדה :attribute לא יכול להיות גדול מ-:max.',
        'string' => 'שדה :attribute לא יכול להיות גדול מ-:max תווים.',
    ],
    'max_digits' => 'שדה :attribute לא יכול להכיל יותר מ-:max ספרות.',
    'mimes' => 'שדה :attribute חייב להיות קובץ מסוג: :values.',
    'mimetypes' => 'שדה :attribute חייב להיות קובץ מסוג: :values.',
    'min' => [
        'array' => 'שדה :attribute חייב לכלול לפחות :min פריטים.',
        'file' => 'שדה :attribute חייב להיות לפחות :min קילובייטים.',
        'numeric' => 'שדה :attribute חייב להיות לפחות :min.',
        'string' => 'שדה :attribute חייב להיות לפחות :min תווים.',
    ],
    'min_digits' => 'שדה :attribute חייב להכיל לפחות :min ספרות.',
    'multiple_of' => 'שדה :attribute חייב להיות מרובה של :value.',
    'not_in' => 'הערך שנבחר לשדה :attribute אינו תקין.',
    'not_regex' => 'פורמט הערך של :attribute אינו תקין.',
    'numeric' => 'שדה :attribute חייב להיות מספר.',
    'password' => [
        'letters' => 'שדה :attribute חייב להכיל לפחות אות אחת.',
        'mixed' => 'שדה :attribute חייב להכיל לפחות אות גדולה אחת ואות קטנה אחת.',
        'numbers' => 'שדה :attribute חייב להכיל לפחות מספר אחד.',
        'symbols' => 'שדה :attribute חייב להכיל לפחות סמל אחד.',
        'uncompromised' => 'הערך שהוזן בשדה :attribute הופיע בחשיפת מידע. אנא בחר ערך אחר',
    ],
    'present' => 'שדה :attribute חייב להיות נוכח.',
    'prohibited' => 'שדה :attribute אסור.',
    'prohibited_if' => 'שדה :attribute אסור כאשר :other הוא :value.',
    'prohibited_unless' => 'שדה :attribute אסור אלא אם :other הוא אחד מ-:values.',
    'prohibits' => 'שדה :attribute מונע מ-:other להיות נוכח.',
    'regex' => 'פורמט הערך של :attribute אינו תקין.',
    'required' => 'שדה :attribute הוא שדה חובה.',
    'required_array_keys' => 'שדה :attribute חייב להכיל ערכים עבור: :values.',
    'required_if' => 'שדה :attribute נדרש כאשר :other הוא :value.',
    'required_if_accepted' => 'שדה :attribute נדרש כאשר :other מתקבל.',
    'required_unless' => 'שדה :attribute נדרש אלא אם :other הוא אחד מ-:values.',
    'required_with' => 'שדה :attribute נדרש כאשר :values נמצאים.',
    'required_with_all' => 'שדה :attribute נדרש כאשר כל הערכים: :values נמצאים.',
    'required_without' => 'שדה :attribute נדרש כאשר :values לא נמצאים.',
    'required_without_all' => 'שדה :attribute נדרש כאשר אף אחד מהערכים: :values לא נמצאים.',
    'same' => 'הערך של :attribute חייב להיות זהה ל-:other.',
    'size' => [
        'array' => 'שדה :attribute חייב להכיל :size פריטים.',
        'file' => 'שדה :attribute חייב להיות :size קילובייט.',
        'numeric' => 'שדה :attribute חייב להיות :size.',
        'string' => 'שדה :attribute חייב להיות :size תווים.',
    ],
    'starts_with' => 'הערך של :attribute חייב להתחיל באחד מהערכים הבאים: :values.',
    'string' => 'הערך של :attribute חייב להיות מחרוזת.',
    'timezone' => 'הערך של :attribute חייב להיות אזור זמן תקף.',
    'unique' => ':attribute כבר תפוס.',
    'uploaded' => 'העלאת הקובץ :attribute נכשלה.',
    'url' => 'הערך של :attribute חייב להיות כתובת URL תקינה.',
    'uuid' => 'הערך של :attribute חייב להיות UUID תקין.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
