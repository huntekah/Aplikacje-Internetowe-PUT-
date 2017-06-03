using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace WebApplication2.Controllers
{
    public class SongsController : Controller
    {
        // GET: Songs
        public ActionResult Index()
        {
         // return Content("Hello World");
            return View();
        }
  
        public ActionResult Square(int id)
        {
            
            return Content((id * id).ToString());
        }
        public ActionResult Square23()
        {
            return Square(23);
        }
    }
}