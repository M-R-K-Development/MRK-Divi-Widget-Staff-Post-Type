<?php

class MRK_Divi_Widget_Staff_Post_Type_Activate
{

    public static function activate()
    {
        custom_post_type_staff();
        flush_rewrite_rules();
    }
}
