import java.io.File;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Scanner;

public class memory_sort
{
    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("memory_sort.dat"));
        ArrayList<RAM> ram = new ArrayList<>();

        while(fromFile.hasNextLine())
        {
            String[] data = fromFile.nextLine().split(",");
            ram.add(new RAM(data[0],data[1],data[2]));
        }

        Collections.sort(ram);

        for(int x=ram.size()-1; x>=0;x--)
            System.out.println(ram.get(x));
    }
}

class RAM implements Comparable
{
    String name,size, speed;

    public RAM(String name, String size, String speed) {
        this.name = name;
        this.size = size;
        this.speed = speed;
    }

    public int compareTo(Object o)
    {
        RAM r = (RAM)o;

        String ramType = size.substring(size.length()-2);
        String otherRamType = r.size.substring(r.size.length()-2);

        int ramSize= Integer.parseInt(size.substring(0,size.length()-2));
        int otherRamSize= Integer.parseInt(r.size.substring(0,r.size.length()-2));

        int ramSpeed= Integer.parseInt(speed.substring(0,speed.length()-3));
        int otherRamSpeed= Integer.parseInt(r.speed.substring(0,r.speed.length()-3));

        //System.out.println("ME" +name +" "+ramSize+"x"+ramType+ " "+ramSpeed);
        //System.out.println("Other" +r.name +" "+otherRamSize+"x"+otherRamType+ " "+otherRamSpeed);
        if(!name.equals(r.name))
            return r.name.compareTo(name);
        else if(!ramType.equals(otherRamType))
        {
            if(ramType.equals("MB"))
                return -1;
            else
                return 1;
        }
        else
        {
            if(ramSize!=otherRamSize)
                return ramSize-otherRamSize;
            else
                return ramSpeed-otherRamSpeed;
        }
    }

    public String toString()
    {
        return name + " - ("+size+"/"+speed+")";
    }
}