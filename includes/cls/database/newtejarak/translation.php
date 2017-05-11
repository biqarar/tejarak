<?php
private function transtext()
{

	// ------------------------------------------------------------ Table branchs
	echo T_("branchs");             // Table branchs
	echo T_("branch");              // branch
	echo T_("enable");              // Enum enable
	echo T_("disable");             // Enum disable
	echo T_("expire");              // Enum expire
	echo T_("id");                  // id
	echo T_("company");             // company_id
	echo T_("title");               // title
	echo T_("brand");               // brand
	echo T_("site");                // site
	echo T_("boss");                // boss
	echo T_("creator");             // creator
	echo T_("technical");           // technical
	echo T_("address");             // address
	echo T_("code");                // code
	echo T_("telegram");            // telegram_id
	echo T_("1");                   // phone_1
	echo T_("2");                   // phone_2
	echo T_("3");                   // phone_3
	echo T_("fax");                 // fax
	echo T_("email");               // email
	echo T_("code");                // post_code
	echo T_("time");                // full_time
	echo T_("remote");              // remote
	echo T_("default");             // is_default
	echo T_("status");              // status
	echo T_("createdate");          // createdate
	echo T_("modified");            // date_modified
	echo T_("desc");                // desc
	echo T_("meta");                // meta

	// ------------------------------------------------------------ Table comments
	echo T_("comments");            // Table comments
	echo T_("comment");             // comment
	echo T_("approved");            // Enum approved
	echo T_("unapproved");          // Enum unapproved
	echo T_("spam");                // Enum spam
	echo T_("deleted");             // Enum deleted
	echo T_("comment");             // Enum comment
	echo T_("rate");                // Enum rate
	echo T_("post");                // post_id
	echo T_("author");              // comment_author
	echo T_("email");               // comment_email
	echo T_("url");                 // comment_url
	echo T_("content");             // comment_content
	echo T_("meta");                // comment_meta
	echo T_("status");              // comment_status
	echo T_("parent");              // comment_parent
	echo T_("user");                // user_id
	echo T_("minus");               // comment_minus
	echo T_("plus");                // comment_plus
	echo T_("type");                // comment_type
	echo T_("visitor");             // visitor_id

	// ------------------------------------------------------------ Table companies
	echo T_("companies");           // Table companies
	echo T_("companie");            // companie
	echo T_("code");                // register_code
	echo T_("code");                // economical_code
	echo T_("file");                // file_id
	echo T_("logo");                // logo
	echo T_("alias");               // alias
	echo T_("plan");                // plan
	echo T_("until");               // until

	// ------------------------------------------------------------ Table getwaies
	echo T_("getwaies");            // Table getwaies
	echo T_("getwaie");             // getwaie
	echo T_("branch");              // branch_id
	echo T_("cat");                 // cat
	echo T_("ip");                  // ip
	echo T_("agent");               // agent_id

	// ------------------------------------------------------------ Table hourlogs
	echo T_("hourlogs");            // Table hourlogs
	echo T_("hourlog");             // hourlog
	echo T_("enter");               // Enum enter
	echo T_("exit");                // Enum exit
	echo T_("usercompany");         // usercompany_id
	echo T_("userbranch");          // userbranch_id
	echo T_("date");                // date
	echo T_("date");                // shamsi_date
	echo T_("time");                // time
	echo T_("minus");               // minus
	echo T_("plus");                // plus
	echo T_("type");                // type

	// ------------------------------------------------------------ Table hours
	echo T_("hours");               // Table hours
	echo T_("hour");                // hour
	echo T_("nothing");             // Enum nothing
	echo T_("base");                // Enum base
	echo T_("wplus");               // Enum wplus
	echo T_("wminus");              // Enum wminus
	echo T_("all");                 // Enum all
	echo T_("active");              // Enum active
	echo T_("awaiting");            // Enum awaiting
	echo T_("deactive");            // Enum deactive
	echo T_("removed");             // Enum removed
	echo T_("filter");              // Enum filter
	echo T_("getway_id");           // start_getway_id
	echo T_("getway_id");           // end_getway_id
	echo T_("userbranch_id");       // start_userbranch_id
	echo T_("userbranch_id");       // end_userbranch_id
	echo T_("year");                // year
	echo T_("month");               // month
	echo T_("day");                 // day
	echo T_("year");                // shamsi_year
	echo T_("month");               // shamsi_month
	echo T_("day");                 // shamsi_day
	echo T_("start");               // start
	echo T_("end");                 // end
	echo T_("diff");                // diff
	echo T_("accepted");            // accepted

	// ------------------------------------------------------------ Table invoice_details
	echo T_("invoice_details");     // Table invoice_details
	echo T_("invoice_detail");      // invoice_detail
	echo T_("invoice");             // invoice_id
	echo T_("price");               // price
	echo T_("count");               // count
	echo T_("total");               // total
	echo T_("discount");            // discount

	// ------------------------------------------------------------ Table invoices
	echo T_("invoices");            // Table invoices
	echo T_("invoice");             // invoice
	echo T_("user _seller");        // user_id_seller
	echo T_("temp");                // temp
	echo T_("discount");            // total_discount
	echo T_("pay");                 // date_pay
	echo T_("bank");                // transaction_bank
	echo T_("vat");                 // vat
	echo T_("pay");                 // vat_pay
	echo T_("total");               // final_total
	echo T_("detail");              // count_detail

	// ------------------------------------------------------------ Table logitems
	echo T_("logitems");            // Table logitems
	echo T_("logitem");             // logitem
	echo T_("critical");            // Enum critical
	echo T_("high");                // Enum high
	echo T_("medium");              // Enum medium
	echo T_("low");                 // Enum low
	echo T_("type");                // logitem_type
	echo T_("caller");              // logitem_caller
	echo T_("title");               // logitem_title
	echo T_("desc");                // logitem_desc
	echo T_("meta");                // logitem_meta
	echo T_("priority");            // logitem_priority

	// ------------------------------------------------------------ Table logs
	echo T_("logs");                // Table logs
	echo T_("log");                 // log
	echo T_("deliver");             // Enum deliver
	echo T_("logitem");             // logitem_id
	echo T_("data");                // log_data
	echo T_("meta");                // log_meta
	echo T_("status");              // log_status
	echo T_("createdate");          // log_createdate

	// ------------------------------------------------------------ Table notifications
	echo T_("notifications");       // Table notifications
	echo T_("notification");        // notification
	echo T_("read");                // Enum read
	echo T_("unread");              // Enum unread
	echo T_("user sender");         // user_idsender
	echo T_("title");               // notification_title
	echo T_("content");             // notification_content
	echo T_("meta");                // notification_meta
	echo T_("url");                 // notification_url
	echo T_("status");              // notification_status

	// ------------------------------------------------------------ Table options
	echo T_("options");             // Table options
	echo T_("option");              // option
	echo T_("parent");              // parent_id
	echo T_("cat");                 // option_cat
	echo T_("key");                 // option_key
	echo T_("value");               // option_value
	echo T_("meta");                // option_meta
	echo T_("status");              // option_status

	// ------------------------------------------------------------ Table posts
	echo T_("posts");               // Table posts
	echo T_("post");                // post
	echo T_("open");                // Enum open
	echo T_("closed");              // Enum closed
	echo T_("publish");             // Enum publish
	echo T_("draft");               // Enum draft
	echo T_("schedule");            // Enum schedule
	echo T_("language");            // post_language
	echo T_("title");               // post_title
	echo T_("slug");                // post_slug
	echo T_("url");                 // post_url
	echo T_("content");             // post_content
	echo T_("meta");                // post_meta
	echo T_("type");                // post_type
	echo T_("comment");             // post_comment
	echo T_("count");               // post_count
	echo T_("order");               // post_order
	echo T_("status");              // post_status
	echo T_("parent");              // post_parent
	echo T_("publishdate");         // post_publishdate

	// ------------------------------------------------------------ Table sessions
	echo T_("sessions");            // Table sessions
	echo T_("session");             // session
	echo T_("terminate");           // Enum terminate
	echo T_("changed");             // Enum changed
	echo T_("logout");              // Enum logout
	echo T_("seen");                // last_seen

	// ------------------------------------------------------------ Table terms
	echo T_("terms");               // Table terms
	echo T_("term");                // term
	echo T_("expired");             // Enum expired
	echo T_("filtered");            // Enum filtered
	echo T_("blocked");             // Enum blocked
	echo T_("violence");            // Enum violence
	echo T_("pornography");         // Enum pornography
	echo T_("other");               // Enum other
	echo T_("language");            // term_language
	echo T_("type");                // term_type
	echo T_("caller");              // term_caller
	echo T_("title");               // term_title
	echo T_("slug");                // term_slug
	echo T_("url");                 // term_url
	echo T_("desc");                // term_desc
	echo T_("meta");                // term_meta
	echo T_("parent");              // term_parent
	echo T_("status");              // term_status
	echo T_("count");               // term_count
	echo T_("usercount");           // term_usercount

	// ------------------------------------------------------------ Table termusages
	echo T_("termusages");          // Table termusages
	echo T_("termusage");           // termusage
	echo T_("posts");               // Enum posts
	echo T_("products");            // Enum products
	echo T_("attachments");         // Enum attachments
	echo T_("files");               // Enum files
	echo T_("comments");            // Enum comments
	echo T_("users");               // Enum users
	echo T_("term");                // term_id
	echo T_("termusage");           // termusage_id
	echo T_("foreign");             // termusage_foreign
	echo T_("order");               // termusage_order

	// ------------------------------------------------------------ Table userbranchs
	echo T_("userbranchs");         // Table userbranchs
	echo T_("userbranch");          // userbranch
	echo T_("postion");             // postion
	echo T_("enter");               // date_enter
	echo T_("exit");                // date_exit

	// ------------------------------------------------------------ Table usercompanies
	echo T_("usercompanies");       // Table usercompanies
	echo T_("usercompanie");        // usercompanie

	// ------------------------------------------------------------ Table users
	echo T_("users");               // Table users
	echo T_("user");                // user
	echo T_("mobile");              // user_mobile
	echo T_("email");               // user_email
	echo T_("pass");                // user_pass
	echo T_("displayname");         // user_displayname
	echo T_("meta");                // user_meta
	echo T_("status");              // user_status
	echo T_("parent");              // user_parent
	echo T_("permission");          // user_permission
	echo T_("createdate");          // user_createdate
	echo T_("username");            // user_username
	echo T_("group");               // user_group
	echo T_("file_id");             // user_file_id
	echo T_("chat_id");             // user_chat_id

}
?>