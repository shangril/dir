The live version of the Dir is available at http://[fc71:fa3a:414d:fe82:f465:369b:141a:f8c]/dir/ for people *already connected to Hyperboria* only. 

Learn how here - The following Hyperboria HOWTO is courtesy of Crem Road records, under CC BY-SA


What is Hyperboria

Hyperboria is a virtual network, propelled by the Cjdns free software, fully end-to-end encrypted, with encryption-based addressing, used at a worldwide scale to provide to its users

*   A secure, trusted, privacy friendly network

*   which is untakedownable, resistant to censorship and to severely disruptive situations

Cjdns is the software. It does the routing, relaying encrypted communication from node to node, to have them reaching their destination. It also does the encryption, making sure of the following:

*   Since the communications are end-to-end encrypted, no one relaying them can access or counterfeit them

*   Since addressing is encryption-based, it authenticates the source and the destination IP address: you are always sure that a particular address is for sure the one it's supposed to be

Cjdns, and therefore Hyperboria, can be used on any network medium supporting the common TCP/IP internet protocol. Then, it can be used through tunnels over internet, linking distant nodes all over the world. As well, it can be used over Local Are Network medium such as Wifi, Ethernet cable or BPL, to provide neighbour-to neighbour connectivity. In this case, the more the range extends, the more the range extends.

Due to the mesh nature of this network, with peers relaying data from node to node, a worldwide network is then constituted. It is called Hyperboria.

I clicked on the link and the site doesn't load !

It is likely to be normal if you are still not connected to Hyperboria. You will learn how to do so in the next section of this page.

How to connect to Hyperboria

Obtaining Cjdns

There's two ways to get the Cjdns software:

You can simply download a precompiled executable of Cjdns brought to you by cjdns.ca, for Linux, MacOS, Windows and Android

If you are familiar with compiling software, you can make your own executable from the sources, which are available at github.com/cjdelisle/cjdns/

Note that the Cjdns' github is the central place for up-to-date documentation if you run into any kind of problem. Note that for MacOS Cjdns is available through the MacPorts project, and some other UNIXes like Linux and so have Cjdns prepackaged in their respective software channels

Generating your key pair/configuration file

Once you have a cjdns executable (which is mostly likely to be simply called cjdns on most system. On Windows, like any Windows binary, it will be called cjdns.exe) it will be time to launch it just to have it generating your conf file, which, most importantly, will contains your encryption public and (important) private keys. Make sure these keys are kept safe and no one can steal the private one. Your confidentiality of communications and authentication of your Hyperboria IP address are assured by this safety. In a terminal prompt, providing you are in the same directory than your executable here, kindly ask him to generate your initial configuration file with the following command :

    On UNIX-style OSes (anything outside Windows), enter in a terminal the command
    cjdroute --genconf >> cjdroute.conf
    On Windows machine, enter in the command line prompt the command
    cjdroute.exe --genconf >> cjdroute.conf

At this point you'll get your own cjdroute.conf text file available in the same directory.

Launch it up

Then, cjdns has to be launched, with administrator ("root") rights. Note that it reads and write 0 files, but needs administrator privilège, because it will create a "virtual network interface" called tun0 which will connect you to Hyperboria. This is done with the following command:

    Windows: cjdroute.exe < cjdroute.conf
    Other: cjdroute < cjdroute.conf

Firewalling tun0

On Windows then you should see Windows Firewall indicating that a new network is available, and ask you if it's a home network or a public network. Since Hyperboria is a public network, select "public" just as you would do for a restaurant wifi. See bottom note 1.

On UNIX-style machines, you'll have to configure your system's firewall to block incoming traffic over tun0, since you don't wan't your own, say, local shared folder to be exposed to the world. With the commonly used ufw uncomplicated firewall, it's done with the command ufw deny in on tun0 (as root). See bottom note 1.

Your link above still doesn't load!

And that's because you setup Cjdns but are not peering with any other Hyperboria Cjdns node. Keep calm, public peering servers are waiting for you to join! Just see
cjdns.ca/peers.txt for some of them, with their publickey. You can select one ore more, and just edit cjdroute.conf to paste the code block in the corresponding section called '(IPv4 only) "connectTo": {' for IPv4 peers of the form XXX.XXX.XXX.XXX:XXXXX where each X is a number.

Then restart Cjdns ([CTRL]+C in the terminal window in which you launched it, to terminate it) and then, you are on Hype.

Help

Nice ways to seek help are EFNet's IRC network, channel #cjdns. Channel #cjdns on pkt.chat ; some other places. All these chatrooms are mutually bridged.

Must-read

Many interesting things, like autopeering over local network medium, compiling from source, and so on, are provided by Janmesh.net (Joint Access Mesh Networking).

FAQ

   Is Hyperboria a darknet?

   Technically yes, but it differs strongly to what is put behind this word usually. Total anonymousity is not the priority. The aim is more to build a trusted network
  
   Your Hype sites URLs given above are not https!
   
   And that's normal. ANY communication throught Cjdns is encrypted as a default. There is no need to re-encrypt at a higher network stack level a communication with a webserver that is already encrypted.

Last words

"Prepare for the inevitable, and have fun doing it" (Stuart D. Gathman)

Bottom notes

Note 1: Cjdns doesn't behave like your NAT ISP Box or a mobile phone's data access, but more similary to a directly connected to internet server machine with a public Internet (not LAN) IP. Then, on any machine running Cjdns, all open and listening ports will be available to the peered Hyperboria network as a whole. So Make sure your firewall is running and blocking incoming traffic for the particular tun0 interface that Cjdns will create. 
