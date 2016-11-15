function removeElement(arr, sElement)
{
    var tmp = new Array();
    for (var i = 0; i<arr.length; i++) if (arr[i] != sElement) tmp[tmp.length] = arr[i];
    arr=null;
    arr=new Array();
    for (var i = 0; i<tmp.length; i++) arr[i] = tmp[i];
    tmp = null;
    return arr;
}

function SectionClick(id)
{
    var div = document.getElementById('user_div_'+id);
    if (div.hasAttribute('hidden'))
    {
        opened_sections[opened_sections.length]=id;
        div.removeAttribute('hidden');
    }
    else
    {
        opened_sections = removeElement(opened_sections, id);
        div.setAttribute("hidden", true);
    }

    document.cookie = "_user_profile_open=" + opened_sections.join(",") + "; expires=Thu, 31 Dec 2020 23:59:59 GMT; path=/;";
}

